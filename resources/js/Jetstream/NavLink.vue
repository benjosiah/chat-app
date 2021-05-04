<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                            ? 'inline-flex items-center font-semibold  px-1 pt-1 border-b-2 border-indigo-100 text-2xl font-medium leading-5 text-white  focus:outline-none focus:border-indigo-900 transition duration-150 ease-in-out'
                            : 'inline-flex items-center font-semibold px-1 pt-1 border-b-2 border-transparent text-2xl font-medium leading-5 text-gray-200 hover:text-gray-700 hover:border-gray-100 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
            }
        }
    }
</script>
