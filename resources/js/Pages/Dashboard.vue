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
                <div class="tw-max-w-xs tw-rounded tw-overflow-hidden tw-shadow-lg tw-my-2">
                  <img
                    class="tw-w-full"
                    src="https://tailwindcss.com/img/card-top.jpg"
                    alt="Sunset in the mountains"
                  />
                  <div class="tw-px-6 tw-py-4">
                    <div class="tw-font-bold tw-text-xl tw-mb-2">The Coldest Sunset {{ data }}</div>
                    <p class="text-grey-darker tw-text-base">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                      Voluptatibus quia, nulla! Maiores et perferendis eaque,
                      exercitationem praesentium nihil.
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
  data(){
            return{
                props: ['data'],
            }
  }
};
</script>
