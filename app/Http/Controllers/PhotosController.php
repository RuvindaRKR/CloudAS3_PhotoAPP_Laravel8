<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
// Reference: [1]"Step 5: Query and Scan the Data - Amazon DynamoDB", Docs.aws.amazon.com, 2021. [Online]. Available: https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/GettingStarted.PHP.04.html#GettingStarted.PHP.04.Query.02. [Accessed: 28- Apr- 2021].
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use \Aws;

//use Aws\Laravel\AwsFacade as AWS; 

class PhotosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$data = Photo::all();
        $user = $request->user();
        $data = Photo::where('user_id', $user->id)->paginate(5);
        return Inertia::render('MyPhotos', ['photoData' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        Validator::make($request->all(), [
            'uploadedPhoto' => ['required', 'mimes:jpg,jpeg,png', 'max:10240'],
            'title' => ['required'],
            'description' => ['required'],
        ])->validate();

        $photo = new Photo();
        $photo->user_id = $user->id;
        //Reference: [3]"File Storage - Laravel - The PHP Framework For Web Artisans", Laravel.com, 2021. [Online]. Available: https://laravel.com/docs/8.x/filesystem#specifying-a-disk. [Accessed: 07- Jun- 2021].
        $photo->photo_path = $request->file('uploadedPhoto')->storePublicly('photo-uploads/'.$user->id, 's3');
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->likes = 0;
        $photo->rank = 0;

        $photo->save();

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

        $json = json_encode([
            'id' => strval($photo->id),
            'email' => $user->email,
            'likes' => 0,            
            'user_id' => $user->id,
            'ranking' => 0,
        ]);
    
        $params = [
            'TableName' => $tableName,
            'Item' => $marshaler->marshalJson($json)
        ];
    
        try {
            $dynamodb->putItem($params);
        } catch (DynamoDbException $e) {
            echo $e->getMessage() . "\n";
        }

        // return response('Successfully Uploaded Photo', 201);
        // return Redirect::route('photos.index');
        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Photo::find($id);
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

        $photo = Photo::find($id);
        $photo->title = $request->title;
        $photo->description = $request->description;

        $photo->save();

        return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        Storage::disk('s3')->delete($photo->photo_path);
        $photo->delete();

        $sdk = new Aws\Sdk([
            'region'   => 'ap-southeast-1',
            'version'  => 'latest',
        ]);
      
        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Marshaler();
        
        $tableName = 'photos';
        $key = $marshaler->marshalJson('{"id": "' . $id . '"}');

        $params = [
            'TableName' => $tableName,
            'Key' => $key
        ];

        try {
            $dynamodb->deleteItem($params);
        } catch (DynamoDbException $e) {
            echo $e->getMessage() . "\n";
        }
            //return response('Successfully Deleted Photo', 200);
            return redirect()->back()
                        ->with('message', 'Post Deleted Successfully.');
        }
    
}
