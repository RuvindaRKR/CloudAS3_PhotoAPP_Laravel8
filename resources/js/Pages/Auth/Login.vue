<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="tw-mb-4" />

        <div v-if="status" class="tw-mb-4 tw-font-medium tw-text-sm tw-text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="tw-mt-1 tw-block tw-w-full" v-model="form.email" required autofocus />
            </div>

            <div class="tw-mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="tw-mt-1 tw-block tw-w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="tw-block tw-mt-4">
                <label class="tw-flex tw-items-center">
                    <jet-checkbox name="remember" v-model:checked="form.remember" />
                    <span class="tw-ml-2 tw-text-sm tw-text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
                <inertia-link v-if="canResetPassword" :href="route('password.request')" class="tw-underline tw-text-sm tw-text-gray-600 hover:tw-text-gray-900">
                    Forgot your password?
                </inertia-link>

                <jet-button class="tw-ml-4" :class="{ 'tw-opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
