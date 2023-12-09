<script setup>
import { Head } from '@inertiajs/vue3';
import PropertySearchForm from '../Components/PropertySearchForm.vue';
import route from '../route';

defineProps({
    errors: {
        type: Object,
        default: () => {}
    },
    results: {
        type: Object,
        default: () => {}
    },
    filters: {
        type: Object,
        default: () => {}
    }
});
</script>

<template>
    <Head>
        <title>Home Page</title>
    </Head>

    <el-row justify="center">
        <el-col :sm="18">
            <h2 class="title">Property search</h2>

            <PropertySearchForm
                :submit-url="route('home')"
                :errors="errors"
                :results="results"
                :filters="filters"
            ></PropertySearchForm>
        </el-col>
    </el-row>
</template>

<style>
    .title {
        margin-bottom: 20px;
        font-weight: var(--el-font-weight-primary);
        font-size: var(--el-font-size-large);
        font-family: var(--el-font-family);
        text-transform: uppercase;
    }
</style>
