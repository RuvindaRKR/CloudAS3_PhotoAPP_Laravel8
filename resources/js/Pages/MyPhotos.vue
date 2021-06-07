<template>
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
                            <!-- <form @submit.prevent="uploadPhoto"> -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadPhotoModalLabel">Upload a new photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="uploadPhoto">
                                        <div class="mb-3">
                                            <label for="uploadedPhoto" class="form-label">Photo</label>
                                            <input type="file" ref="uploadedPhoto" @change="updatePhotoPreview" class="form-control" id="uploadedPhoto">
                                        </div> 

                                        <!-- New Profile Photo Preview -->
                                        <div class="" v-show="photoPreview">
                                            <span class="object-contain tw-h-48 tw-w-full tw-bg-gray-500 tw-flex tw-items-center tw-justify-center tw-overflow-hidden"
                                                :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" v-model="photo.title" class="form-control" id="title">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" v-model="photo.description" rows="5" id="description"></textarea>
                                        </div>  
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                </div>
                            <!-- </form> -->
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
                                    <span class="tw-sr-only">Edit</span>
                                </th>
                                </tr>
                            </thead>
                            <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                                <tr v-for="x in photos" :key="x.id">
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-flex tw-items-center">
                                        <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                            <img class="tw-h-10 tw-w-10 tw-rounded-full" :src="x.photo_path" alt="">
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
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            AppLayout,
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        data(){
            return{
                form: this.$inertia.form({
                    _method: 'PUT',
                    title:'',
                    description:'',
                    uploadedPhoto: null,
                }),

                photoPreview: null,

                photos:[],
                photo:{
                    uploadedPhoto:null,
                    title:'',
                    description:''
                },

            }  
        },

        methods:{
            async uploadPhoto(){
                let formData = new FormData();

                if (this.$refs.uploadedPhoto) {
                    this.photo.uploadedPhoto = this.$refs.uploadedPhoto.files[0];
                    formData.append('uploadedPhoto', this.photo.uploadedPhoto);
                }

                formData.append('description', this.photo.description);
                formData.append('title', this.photo.title);

                const res = await axios.post('/api/photos', formData)

                if (res.status === 201) {
                    Toast.fire({
                        icon:'success',
                        title:res.data
                    })
                }

            },

            // uploadPhoto() {
            //     if (this.$refs.uploadedPhoto) {
            //         this.photo.uploadedPhoto = this.$refs.uploadedPhoto.files[0];
            //     }

            //     this.form.post(route('photo.store'), {
            //         errorBag: 'storePhoto',
            //         preserveScroll: true,
            //         onSuccess: () => (this.clearPhotoFileInput()),
            //     });
            // },


            getPhotos(){
                axois.get('api/photos')
                .then((res) => {
                    this.photos = res.data
                }).catch((err) => {
                    console.log(err)
                });

            },

            selectNewPhoto() {
                this.$refs.uploadedPhoto.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.uploadedPhoto.files[0];
                this.photo.uploadedPhoto = this.$refs.uploadedPhoto.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            clearPhotoFileInput() {
                if (this.$refs.uploadedPhoto?.value) {
                    this.$refs.uploadedPhoto.value = null;
                }
            },
        }
    }
</script>
