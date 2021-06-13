<template>
  <app-layout>
    <template #header>
      <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">Manage Subscription</h2>
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
                <h2 class="font-bold text-2xl">Hang on there! You need an active subscription before proceeding.</h2>
                  <p>
                    <jet-button class="mt-4" v-on:click="subscribeViaPortal()">Head to checkout page</jet-button>
                  </p>
              
              </div>
            </div>
          </body>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import JetButton from '../Jetstream/Button';
import AppLayout from '../Layouts/AppLayout';
export default {
  components: {
    JetButton,
    AppLayout
  },
  props: ['stripeKey', 'checkoutSessionId'],
//   props: ['checkout'],

  methods: {
    checkout() {
      Stripe(this.stripeKey).redirectToCheckout({
        sessionId: this.checkoutSessionId
      });
    },

    /* 
      Subscripbe Via Stripe Checkout Session Portal
    */
    subscribeViaPortal() {
      var stripe = Stripe(this.stripeKey);
          stripe.redirectToCheckout({
            sessionId: this.checkoutSessionId,
          });
    },
  }
}
</script>