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
              
                <span v-for="x in data" :key="x.id">
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
                    <p class="text-grey-darker tw-text-base">
                      {{x.likes}} Likes 
                      <span class="invisible">{{liked = false}}</span> 
                      <span v-for="y in likes" :key="y.id">
                        <span v-if="x.id == y.photo_id">
                          <span class="invisible">{{liked = true}}</span> 
                        </span>                 
                      </span>
                      <span v-if="liked == true">
                        <i class="fas fa-heart fa-lg"></i>
                          <!-- <button class="btn" @click="dislike(x)"><i class="fas fa-heart fa-lg"></i></button> -->
                      </span>
                      <span v-else>
                        <button class="btn" @click="like(x)"><i class="far fa-heart fa-lg"></i></button>
                      </span>
                    </p>
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

export default {
  components: {
    AppLayout,
    Welcome,
  },

  props: ['data', 'likes', 'errors'],

  data(){
      return{
              s3url: 'https://photoappas3.s3-ap-southeast-1.amazonaws.com/',
              liked: false,

        }  
  },
  methods:{
    like(data) {
        this.$inertia.put('/dashboard/' + data.id, data, {
            preserveScroll: true,
            onSuccess: () => {
            Toast.fire({
                icon:'success',
                title:'Liked Photo Successfully'
              })
            },
     })
    },

    // dislike(data) {
    //     this.$inertia.delete('/dashboard/' + data.id, data, {
    //         preserveScroll: true,
    //         onSuccess: () => {
    //         Toast.fire({
    //             icon:'success',
    //             title:'Liked Photo Successfully'
    //           })
    //         },
    //  })
    // }

  },
  created(){
            
        }
}
</script>
