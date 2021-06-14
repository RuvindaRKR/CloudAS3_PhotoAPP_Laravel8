<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Likes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use \Aws;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $data = Photo::all();
        $likes = Likes::where('user_id', $user->id)->get();

        //Get ratings from DynamoDB table
        self::updateRanking();

        return Inertia::render('Dashboard', ['data' => $data, 'likes' => $likes, 'user_id' => $user->id]);
    }

    // Reference: [6]Positronx.io, 2021. [Online]. Available: https://www.positronx.io/create-live-search-in-laravel-vue-js-application/. [Accessed: 14- Jun- 2021].
    public function searchPhotos(Request $request)
    {
        $data = Photo::where('title', 'LIKE','%'.$request->keyword.'%')->get();
        return response()->json($data); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();

        $photo = Photo::find($id);
        $photo->likes = $photo->likes + 1;
        $photo->save();

        $like = new Likes();
        $like->user_id = $user->id;
        $like->photo_id = $id;
        $like->save();

        // $sdk = new Aws\Sdk([
        //     'region'   => 'ap-southeast-1',
        //     'version'  => 'latest',
        //     'credentials' => [
        //         'key'    => array_key_exists('AWS_ACCESS_KEY_ID', $_SERVER) ? $_SERVER['AWS_ACCESS_KEY_ID'] :env('AWS_ACCESS_KEY_ID'),
        //         'secret' => array_key_exists('AWS_SECRET_ACCESS_KEY', $_SERVER) ? $_SERVER['AWS_SECRET_ACCESS_KEY'] :env('AWS_SECRET_ACCESS_KEY'),
        //     ],
        // ]);
        $sdk = new Aws\Sdk([
            'region'   => 'ap-southeast-1',
            'version'  => 'latest',
        ]);

        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Marshaler();

        $tableName = 'photos';

        $key = $marshaler->marshalJson('{"id": "' . $id . '"}');

        $eav = $marshaler->marshalJson('{":val": 1}');

        $params = [
            'TableName' => $tableName,
            'Key' => $key,
            'UpdateExpression' => 'set likes = likes + :val',
            'ExpressionAttributeValues' => $eav,
            'ReturnValues' => 'UPDATED_NEW'
        ];

        try {
            $dynamodb->updateItem($params);
        } catch (DynamoDbException $e) {
            echo $e->getMessage() . "\n";
        }

        //Get ratings from DynamoDB table
        self::updateRanking();

        return redirect()->back()
            ->with('message', 'Liked Photo Successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $photo = Photo::find($id);
        if ($photo->likes > 0) {
            $photo->likes = $photo->likes - 1;
            $photo->save();
        }

        //Reference: [4]H. Khan, "ERROR: SQLSTATE[42S22]: Column not found: 1054 Unknown column '0' in 'where clause'", Stack Overflow, 2021. [Online]. Available: https://stackoverflow.com/questions/60957406/error-sqlstate42s22-column-not-found-1054-unknown-column-0-in-where-clau. [Accessed: 12- Jun- 2021].
        Likes::where('photo_id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->delete();

            $sdk = new Aws\Sdk([
                'region'   => 'ap-southeast-1',
                'version'  => 'latest',
            ]);

        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Marshaler();

        //Add like to DynamoDB table
        $tableName = 'photos';

        $key = $marshaler->marshalJson('{"id": "' . $id . '"}');

        $eav = $marshaler->marshalJson('{":val": 1}');

        $params = [
            'TableName' => $tableName,
            'Key' => $key,
            'UpdateExpression' => 'set likes = likes - :val',
            'ExpressionAttributeValues' => $eav,
            'ReturnValues' => 'UPDATED_NEW'
        ];

        try {
            $dynamodb->updateItem($params);
        } catch (DynamoDbException $e) {
            echo $e->getMessage() . "\n";
        }

        //Get ratings from DynamoDB table
        self::updateRanking();



        return redirect()->back()
            ->with('message', 'Disliked Photo Successfully.');
    }

    public static function updateRanking()
    {
        //Get ratings from DynamoDB table

        $sdk = new Aws\Sdk([
            'region'   => 'ap-southeast-1',
            'version'  => 'latest',
        ]);

        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Marshaler();

        $tableName = 'photos';

        $params = [
            'TableName' => $tableName,
        ];

        $result = $dynamodb->scan($params);

            if (!empty($result['Items'])) {
                foreach($result['Items'] as $i){
                    $dynamoPhotos = $marshaler->unmarshalItem($i);
                    $photo = Photo::find($dynamoPhotos['id']);
                    $photo->rank = $dynamoPhotos['ranking'];
                    $photo->save();
                }
            }

        try {
            
        } catch (DynamoDbException $e) {
            echo $e->getMessage() . "\n";
        }


    }
}
