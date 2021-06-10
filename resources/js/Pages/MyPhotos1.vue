<template>
    <app-layout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">
                Manage Post - (Laravel 8 Inertia JS CRUD with Jetstream & Tailwind CSS - ItSolutionStuff.com)
            </h2>
        </template>
        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div class="tw-bg-white tw-overflow-hidden tw-shadow-xl sm:tw-rounded-lg tw-px-4 tw-py-4">
                    <div class="tw-bg-teal-100 tw-border-t-4 tw-border-teal-500 tw-rounded-b tw-text-teal-900 tw-px-4 tw-py-3 tw-shadow-md tw-my-3" role="alert" v-if="$page.props.flash.message">
                      <div class="tw-flex">
                        <div>
                          <p class="tw-text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                      </div>
                    </div>
                    {{ errors.description }}
                    <div v-if="$page.props.errors.description" class="tw-text-red-500">{{ errors.description }}</div>
                    <button @click="openModal()" class="tw-bg-blue-500 hover:tw-bg-blue-700 tw-text-white tw-font-bold tw-py-2 tw-px-4 tw-rounded tw-my-3">Create New Post</button>
                    <table class="tw-table-fixed tw-w-full">
                        <thead>
                            <tr class="tw-bg-gray-100">
                                <th class="tw-px-4 tw-py-2">Image</th>
                                <th class="tw-px-4 tw-py-2 tw-w-20">No.</th>
                                <th class="tw-px-4 tw-py-2">Title</th>
                                <th class="tw-px-4 tw-py-2">Description</th>
                                <th class="tw-px-4 tw-py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data" :key="row.id">
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-flex tw-items-center">
                                        <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                            <img class="tw-h-10 tw-w-10 tw-rounded-full" :src="s3url + row.photo_path" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td class="tw-border tw-px-4 tw-py-2">{{ row.id }}</td>
                                <td class="tw-border tw-px-4 tw-py-2">{{ row.title }}</td>
                                <td class="tw-border tw-px-4 tw-py-2">{{ row.description }}</td>
                                <td class="tw-border tw-px-4 tw-py-2">
                                    <button @click="edit(row)" class="tw-bg-blue-500 hover:tw-bg-blue-700 tw-text-white tw-font-bold tw-py-2 tw-px-4 tw-rounded">Edit</button>
                                    <button @click="deleteRow(row)" class="tw-bg-red-500 hover:tw-bg-red-700 tw-text-white tw-font-bold tw-py-2 tw-px-4 tw-rounded">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="tw-fixed tw-z-10 tw-inset-0 tw-overflow-y-auto tw-ease-out duration-400" v-if="isOpen">
                      <div class="tw-flex tw-items-end tw-justify-center tw-min-h-screen tw-pt-4 tw-px-4 tw-pb-20 tw-text-center sm:tw-block sm:tw-p-0">
                        
                        <div class="tw-fixed tw-inset-0 tw-transition-opacity">
                          <div class="tw-absolute tw-inset-0 tw-bg-gray-500 tw-opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal tw-contents. -->
                        <span class="tw-hidden sm:tw-inline-block sm:tw-align-middle sm:tw-h-screen"></span>​
                        <div class="tw-inline-block tw-align-bottom tw-bg-white tw-rounded-lg tw-text-left tw-overflow-hidden tw-shadow-xl tw-transform tw-transition-all sm:tw-my-8 sm:tw-align-middle sm:tw-max-w-lg sm:tw-w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                          <div class="tw-bg-white tw-px-4 tw-pt-5 tw-pb-4 sm:tw-p-6 sm:tw-pb-4">
                            <div class="">
                                  <div class="tw-mb-4">
                                      <label for="exampleFormControlInput1" class="tw-block tw-text-gray-700 tw-text-sm tw-font-bold tw-mb-2">Title:</label>
                                      <input type="text" class="tw-shadow tw-appearance-none tw-border tw-rounded tw-w-full tw-py-2 tw-px-3 tw-text-gray-700 tw-leading-tight focus:tw-outline-none focus:tw-shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.title">
                                      <div v-if="errors.title" class="tw-text-red-500">{{ errors.title }}</div>
                                  </div>
                                  <div class="tw-mb-4">
                                      <label for="exampleFormControlInput2" class="tw-block tw-text-gray-700 tw-text-sm tw-font-bold tw-mb-2">Description:</label>
                                      <textarea class="tw-shadow tw-appearance-none tw-border tw-rounded tw-w-full tw-py-2 tw-px-3 tw-text-gray-700 tw-leading-tight focus:tw-outline-none focus:tw-shadow-outline" id="exampleFormControlInput2" v-model="form.description" placeholder="Enter Description"></textarea>
                                      <div v-if="$page.props.errors.description" class="tw-text-red-500">{{ $page.props.errors.description[0] }}</div>
                                  </div>
                            </div>
                          </div>
                          <div class="tw-bg-gray-50 tw-px-4 tw-py-3 sm:tw-px-6 sm:tw-flex sm:tw-flex-row-reverse">
                            <span class="tw-flex tw-w-full tw-rounded-md tw-shadow-sm sm:tw-ml-3 sm:tw-w-auto">
                              <button wire:click.prevent="store()" type="button" class="tw-inline-flex tw-justify-center tw-w-full tw-rounded-md tw-border tw-border-transparent tw-px-4 tw-py-2 tw-bg-green-600 tw-text-base tw-leading-6 tw-font-medium tw-text-white tw-shadow-sm hover:tw-bg-green-500 focus:tw-outline-none focus:tw-border-green-700 focus:tw-shadow-outline-green tw-transition tw-ease-in-out tw-duration-150 sm:tw-text-sm sm:tw-leading-5" v-show="!editMode" @click="save(form)">
                                Save
                              </button>
                            </span>
                            <span class="tw-flex tw-w-full tw-rounded-md tw-shadow-sm sm:tw-ml-3 sm:tw-w-auto">
                              <button wire:click.prevent="store()" type="button" class="tw-inline-flex tw-justify-center tw-w-full tw-rounded-md tw-border tw-border-transparent tw-px-4 tw-py-2 tw-bg-green-600 tw-text-base tw-leading-6 tw-font-medium tw-text-white tw-shadow-sm hover:tw-bg-green-500 focus:tw-outline-none focus:tw-border-green-700 focus:tw-shadow-outline-green tw-transition tw-ease-in-out tw-duration-150 sm:tw-text-sm sm:tw-leading-5" v-show="editMode" @click="update(form)">
                                Update
                              </button>
                            </span>
                            <span class="tw-mt-3 tw-flex tw-w-full tw-rounded-md tw-shadow-sm sm:tw-mt-0 sm:tw-w-auto">
                              
                              <button @click="closeModal()" type="button" class="tw-inline-flex tw-justify-center tw-w-full tw-rounded-md tw-border tw-border-gray-300 tw-px-4 tw-py-2 tw-bg-white tw-text-base tw-leading-6 tw-font-medium tw-text-gray-700 tw-shadow-sm hover:tw-text-gray-500 focus:tw-outline-none focus:tw-border-blue-300 focus:tw-shadow-outline-blue tw-transition tw-ease-in-out tw-duration-150 sm:tw-text-sm sm:tw-leading-5">
                                Cancel
                              </button>
                            </span>
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'
    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: ['data', 'errors'],
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    title: null,
                    description: null,
                },
                s3url: 'https://photoappas3.s3-ap-southeast-1.amazonaws.com/',
            }
        },
        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {
                    title: null,
                    description: null,
                }
            },
            save: function (data) {
                this.$inertia.post('/photos1.store', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/photos1/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/photos1/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>