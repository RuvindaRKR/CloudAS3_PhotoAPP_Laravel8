<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Explore</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <body class="bg-gray-100 text-gray-700 font-sans quicksand">
            <div class="p-16">
              <div
                class="
                  grid
                  md:grid-cols-2
                  sm:grid-cols-1
                  lg:grid-cols-3
                  m-5
                  mb-10
                "
              >
                <div class="max-w-xs rounded overflow-hidden shadow-lg my-2">
                  <img
                    class="w-full"
                    src="https://tailwindcss.com/img/card-top.jpg"
                    alt="Sunset in the mountains"
                  />
                  <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-grey-darker text-base">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                      Voluptatibus quia, nulla! Maiores et perferendis eaque,
                      exercitationem praesentium nihil.
                    </p>
                  </div>
                  <div class="px-6 py-4">
                    <span
                      class="
                        inline-block
                        bg-grey-lighter
                        rounded-full
                        px-3
                        py-1
                        text-sm
                        font-semibold
                        text-grey-darker
                        mr-2
                      "
                      >#photography</span
                    >
                    <span
                      class="
                        inline-block
                        bg-grey-lighter
                        rounded-full
                        px-3
                        py-1
                        text-sm
                        font-semibold
                        text-grey-darker
                        mr-2
                      "
                      >#travel</span
                    >
                    <span
                      class="
                        inline-block
                        bg-grey-lighter
                        rounded-full
                        px-3
                        py-1
                        text-sm
                        font-semibold
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
};
</script>
