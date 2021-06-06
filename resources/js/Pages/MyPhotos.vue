<template>
    <app-layout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">
                My Photos
            </h2>
        </template>

        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div class="tw-bg-white tw-overflow-hidden tw-shadow-xl sm:tw-rounded-lg">
                    <button class="btn btn-primary">Subscriptions Portal</button>
                    <div class="tw-flex tw-flex-col">
                    <div class="tw--my-2 tw-overflow-x-auto sm:tw--mx-6 lg:tw--mx-8">
                        <div class="tw-py-2 tw-align-middle tw-inline-block tw-min-w-full sm:tw-px-6 lg:tw-px-8">
                        <div class="tw-shadow tw-overflow-hidden tw-border-b tw-border-gray-200 sm:tw-rounded-lg">
                            <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
                            <thead class="tw-bg-gray-50">
                                <tr>
                                <th scope="col" class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Image
                                </th>
                                <th scope="col" class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="tw-relative tw-px-6 tw-py-3">
                                    <span class="tw-sr-only">Edit</span>
                                </th>
                                </tr>
                            </thead>
                            <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                                <tr>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-flex tw-items-center">
                                        <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                            <img class="tw-h-10 tw-w-10 tw-rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-text-sm tw-text-gray-900">Regional Paradigm Technician</div>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-500">
                                    Admin
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-right tw-text-sm tw-font-medium">
                                    <a href="#" class="tw-text-indigo-600 hover:tw-text-indigo-900">Edit</a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
