<template>
  <app-layout>
    <template #header>
      <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">Explore</h2>
    </template>

    <div class="tw-py-12">
      <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
        <div class="tw-bg-white tw-overflow-hidden tw-shadow-xl sm:tw-rounded-lg">
          <body class="tw-bg-gray-100 tw-text-gray-700 tw-font-sans quicksand">
            <div class="tw-p-16">

              <div class="tw-p-8">
                <div class="tw-bg-white tw-flex tw-items-center tw-rounded-full tw-shadow-xl">
                  <input v-model="keyword" class="tw-rounded-l-full tw-w-full tw-py-4 tw-px-6 tw-text-gray-700 tw-leading-tight focus:tw-outline-none" id="keyword" type="text" placeholder="Search">
                  <div class="tw-p-4">
                    <button v-on:click="search()" class="tw-bg-blue-500 tw-text-white tw-rounded-full tw-p-2 hover:tw-bg-blue-400 focus:tw-outline-none tw-w-12 tw-h-12 tw-flex tw-items-center tw-justify-center">
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                  </div>
                </div>
                <jet-button v-on:click="reset()" class="mt-4">Reset</jet-button><span class="invisible">"  "</span>
                <jet-button v-on:click="sortByRank()" class="mt-4">Sort By Rank</jet-button>

              </div>
              
              <div
                class="
                  tw-grid
                  md:tw-grid-cols-2
                  sm:tw-grid-cols-1
                  lg:tw-grid-cols-3
                  tw-m-5
                  tw-mb-10
                "
              >

                <span v-for="x in PhotoData" :key="x.id">
                  <div class="tw-max-w-xs tw-rounded tw-overflow-hidden tw-shadow-lg tw-my-2">
                  <img
                    class="tw-w-full"
                    :src="s3url + x.photo_path"
                    alt="Sunset in the mountains"
                  />
                  <div class="tw-px-6 tw-py-4">
                    <div class="tw-font-bold tw-text-xl tw-mb-2">{{x.title}}</div>
                    <p class="text-grey-darker tw-text-base">
                      {{x.description}}
                    </p>
                      {{x.likes}} Likes 

                      <!-- Reference: [6]"Array.prototype.some() - JavaScript | MDN", Developer.mozilla.org, 2021. [Online]. Available: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/some. [Accessed: 13- Jun- 2021]. -->
                      <p><span v-if="likes.some((y)=> y.photo_id === x.id)">
                          <button class="btn" @click="dislike(x)"><i class="fas fa-heart fa-lg"></i></button>
                      </span>
                      <span v-else>
                        <span v-if="user_id != x.user_id">
                          <button class="btn" @click="like(x)"><i class="far fa-heart fa-lg"></i></button>
                        </span>
                      </span></p>

                      <span
                      class="
                        tw-inline-block
                        bg-grey-lighter
                        tw-rounded-full
                        tw-px-3
                        tw-py-1
                        tw-text-sm
                        tw-font-semibold
                        text-grey-darker
                        tw-mr-2
                      "
                      >#rank {{x.rank}}</span
                    >
                  </div>
                  <div class="tw-px-6 tw-py-4">
                    <span
                      class="
                        tw-inline-block
                        bg-grey-lighter
                        tw-rounded-full
                        tw-px-3
                        tw-py-1
                        tw-text-sm
                        tw-font-semibold
                        text-grey-darker
                        tw-mr-2
                      "
                      >#photography</span
                    >
                    <span
                      class="
                        tw-inline-block
                        bg-grey-lighter
                        tw-rounded-full
                        tw-px-3
                        tw-py-1
                        tw-text-sm
                        tw-font-semibold
                        text-grey-darker
                        tw-mr-2
                      "
                      >#travel</span
                    >
                    <span
                      class="
                        tw-inline-block
                        bg-grey-lighter
                        tw-rounded-full
                        tw-px-3
                        tw-py-1
                        tw-text-sm
                        tw-font-semibold
                        text-grey-darker
                      "
                      >#winter</span
                    >
                  </div>
                </div>
                </span>
                
              </div>
            </div>
          </body>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import JetButton from '../Jetstream/Button';

export default {
  components: {
    AppLayout,
    Welcome,
    JetButton,
  },

  props: ['PhotoData', 'likes', 'user_id', 'errors'],

  data(){
      return{
              s3url: 'https://photoappas3.s3-ap-southeast-1.amazonaws.com/',
              liked: false,
              awskey: process.env.MIX_AWS_ACCESS_KEY_ID,
              awssecret: process.env.MIX_AWS_SECRET_ACCESS_KEY,
              keyword: null,
        }  
  },

  methods:{
    async like(data) {
        await this.$inertia.put('/dashboard/' + data.id, data, {
            preserveScroll: true,
            onSuccess: () => {
              Toast.fire({
                  icon:'success',
                  title:'Liked Photo Successfully'
                })
              },
        })

  },

    async dislike(data) {
        await this.$inertia.delete('/dashboard/' + data.id, data, {
            preserveScroll: true,
            onSuccess: () => {
              Toast.fire({
                  icon:'success',
                  title:'Disliked Photo Successfully'
                })
              },
        })

    },

    async search() {
        await this.$inertia.get('/search', {
            keyword: this.keyword,
            preserveScroll: true,
            preserveState: true,
          })
        },
    
    async sortByRank() {
        await this.$inertia.get('/sortbyrank', {
            keyword: this.keyword,
            preserveScroll: true,
            preserveState: true,
          })  
        },

    async reset() {
        await this.$inertia.get('/dashboard', {
            keyword: this.keyword,
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
              this.keyword = null;
            },
          })
    },

    callAWSAPI() {
      axios
      .post("https://5nkk1o3bbk.execute-api.ap-southeast-1.amazonaws.com/prod/DynamoDBManager", 
        {
          "operation": "update",
          "tableName": "photos",
          "payload": {
          }
        })
      .then(function (res) {
        console.log(res);
        }
      .bind(this))
      .catch(function (error) {
         console.log(error);
        });
    },

  },
  updated(){
      this.callAWSAPI();  
    }
}
</script>
