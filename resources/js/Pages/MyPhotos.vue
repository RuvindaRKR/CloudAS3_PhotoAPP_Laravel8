<template>
<div>
    <app-layout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">
                My Photos
            </h2>
        </template>

        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                
                <!-- Button trigger modal -->
                <p><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                Upload Photo
                </button></p>

                <!-- Modal -->
                    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <form id="addPhotoForm" @submit.prevent="submit">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadPhotoModalLabel">Upload a new photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="uploadedPhoto" class="form-label">Photo</label>
                                            <input type="file" @input="form.uploadedPhoto = $event.target.files[0]" ref="uploadedPhoto" @change="updatePhotoPreview" class="form-control" id="uploadedPhoto" required>
                                            <div v-if="form.errors.uploadedPhoto" style="color: red;">{{ form.errors.uploadedPhoto }}</div>
                                        </div> 

                                        <!-- New Profile Photo Preview -->
                                        <div class="mb-3" v-show="photoPreview">
                                            <label class="form-label">Preview</label>
                                            <span class="object-contain tw-h-48 tw-w-full tw-bg-gray-500 tw-flex tw-items-center tw-justify-center tw-overflow-hidden"
                                                :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" v-model="form.title" class="form-control" id="title" required>
                                            <div v-if="form.errors.title" style="color: red;">{{ form.errors.title }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" v-model="form.description" rows="5" id="description" required></textarea>
                                            <div v-if="form.errors.description" style="color: red;">{{ form.errors.description }}</div>
                                        </div>  
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                <div class="tw-bg-white tw-overflow-hidden tw-shadow-xl sm:tw-rounded-lg">
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
                                    <span class="tw-sr-only">Action</span>
                                </th>
                                </tr>
                            </thead>
                            <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                                <tr v-for="x in data" :key="x.id">
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-flex tw-items-center">
                                        <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                            <img class="tw-h-10 tw-w-10 tw-rounded-full" :src="s3url + x.photo_path" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-text-sm tw-text-gray-900">{{x.title}}</div>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-500">
                                    {{x.description}}
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-right tw-text-sm tw-font-medium">
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" @click="edit(x)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Edit</button>
                                        <button type="button" class="btn btn-outline-danger" @click="deleteRow(x)">Delete</button>
                                    </div>

                                    <!-- Modal -->
                                        <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <form id="editPhotoForm">
                                                    <div class="modal-body">
                                                        <!-- <div class="card"> -->
                                                            <p><img :src="s3url + form1.photo_path" class="card-img-top" alt=""></p>
                                                            <div>
                                                                <label for="title" class="form-label">Title</label>
                                                                <input type="text" v-model="form1.title" class="form-control" id="title" required>
                                                            </div>
                                                            <div>
                                                                <label for="description" class="form-label">Description</label>
                                                                <textarea class="form-control" v-model="form1.description" rows="5" id="description" required></textarea>
                                                            </div> 
                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary" @click="update(form1)">Update</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>                           
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
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props: ['data', 'errors'],

        data(){
            
            return{
                form: this.$inertia.form({
                    // _method: 'PUT',
                    title:'',
                    description:'',
                    uploadedPhoto: null,
                }),

                form1: {
                    _method: 'PUT',
                    title: null,
                    description: null,
                },
                
                photoPreview: null,

                s3url: 'https://photoappas3.s3-ap-southeast-1.amazonaws.com/',

            }  
        },

        methods:{
            submit() {
                if (this.$refs.uploadedPhoto) {
                    this.form.uploadedPhoto = this.$refs.uploadedPhoto.files[0];
                }

                this.form.post(route('photos.store'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.resetForm();
                        Toast.fire({
                                icon:'success',
                                title:'Post Created Successfully'
                            })
                    },
                });

                },

            update(data) {
                this.$inertia.put('/photos/' + data.id, data, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.resetForm();
                        Toast.fire({
                                icon:'success',
                                title:'Post Updated Successfully'
                            })
                    },
                })

                },

            edit: function (data) {
                this.form1 = Object.assign({}, data);
            },

            selectNewPhoto() {
                this.$refs.uploadedPhoto.click();
            },

            resetForm() {
                $('#uploadPhotoModal').modal('hide');
                $('#editPhotoModal').modal('hide');
                this.photoPreview = null;
                this.form.description = '';
                this.form.title = '';
                document.getElementById("addPhotoForm").reset();
            },

            updatePhotoPreview() {
                const photo = this.$refs.uploadedPhoto.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return;                
                this.$inertia.delete('/photos/' + data.id, {
                    preserveScroll: true,
                    onSuccess: () => {
                            Toast.fire({
                                icon:'success',
                                title:'Post Deleted Successfully'
                            })
                    },
                })

            }
        },
        created(){
            
        }
    }
</script>
