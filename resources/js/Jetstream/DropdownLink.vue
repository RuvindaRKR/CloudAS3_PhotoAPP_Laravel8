<template>
    <div>
        <button type="submit" class="tw-block tw-w-full tw-px-4 tw-py-2 tw-text-sm tw-leading-5 tw-text-gray-700 tw-text-left hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 tw-transition" v-if="as == 'button'">
            <slot></slot>
        </button>
        
        <a :href="href" class="tw-block tw-px-4 tw-py-2 tw-text-sm tw-leading-5 tw-text-gray-700 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 tw-transition" v-else-if="as =='a'">
            <slot></slot>
        </a>

        <inertia-link :href="href" class="tw-block tw-px-4 tw-py-2 tw-text-sm tw-leading-5 tw-text-gray-700 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 tw-transition" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['href', 'as']
    }
</script>
