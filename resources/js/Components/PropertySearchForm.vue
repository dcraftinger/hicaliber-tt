<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import propsConfig from './PropertySearchForm/propsConfig';
import filtersConfig from './PropertySearchForm/filtersConfig';
import tableColumns from './PropertySearchForm/tableColumns';

const props = defineProps(propsConfig);

const formFields = {};

Object.keys(filtersConfig).forEach(key => {
    formFields[key] = Object.prototype.hasOwnProperty.call(props.filters, key)
        ? props.filters[key]
        : filtersConfig[key].defaultValue;
});

const form = reactive(formFields);

const isSubmitting = ref(false);

const priceMin = 0;
const priceMax = 1000000;
const priceStep = 10000;

const currentPage = ref(props.results.current_page || 1);

watch(currentPage, async newValue => {
    if (Number.isInteger(newValue)) {
        router.get(props.submitUrl, {
            ...form,
            page: newValue
        });
    }
});

const marks = computed(() => {
    const results = {};
    const points = [priceMin, Math.round(priceMax / 2), priceMax];

    points.forEach(value => {
        results[value] = `$${value}`;
    });

    return results;
});

router.on('start', () => {
    isSubmitting.value = true;
});

router.on('finish', () => {
    isSubmitting.value = false;
});

const onSubmit = () => {
    if (isSubmitting.value) {
        return;
    }

    router.get(props.submitUrl, form);
};
</script>

<template>
    <el-form :model="form" label-position="top">
        <el-form-item label="Name">
            <el-input v-model="form.name" />
        </el-form-item>
        <el-row>
            <el-col :md="6">
                <el-form-item label="Bedrooms" prop="bedrooms" :error="errors.bedrooms">
                    <el-input-number v-model="form.bedrooms" :min="1" :max="10" />
                </el-form-item>
            </el-col>
            <el-col :md="6">
                <el-form-item label="Bathrooms" prop="bathrooms" :error="errors.bathrooms">
                    <el-input-number v-model="form.bathrooms" :min="1" :max="10" />
                </el-form-item>
            </el-col>
            <el-col :md="6">
                <el-form-item label="Storeys" prop="storeys" :error="errors.storeys">
                    <el-input-number v-model="form.storeys" :min="1" :max="10" />
                </el-form-item>
            </el-col>
            <el-col :md="6">
                <el-form-item label="Garages" prop="garages" :error="errors.garages">
                    <el-input-number v-model="form.garages" :min="1" :max="10" />
                </el-form-item>
            </el-col>
        </el-row>

        <el-form-item label="Price" prop="price" :error="errors['price.1'] ?? errors['price.2']">
            <div style="width: 100%; margin: 0 10px 20px">
                <el-slider
                    v-model="form.price"
                    range
                    :format-tooltip="value => `$${value}`"
                    :marks="marks"
                    :step="priceStep"
                    :min="priceMin"
                    :max="priceMax"
                />
            </div>
        </el-form-item>
        <el-form-item mt="large">
            <el-button type="primary" :disabled="isSubmitting" @click="onSubmit">Search</el-button>
        </el-form-item>
    </el-form>

    <template v-if="results.data.length">
        <el-table v-loading="isSubmitting" :data="results.data" style="width: 100%">
            <el-table-column
                v-for="(value, key) in tableColumns"
                :key="key"
                :prop="key"
                :label="value.label"
                :min-width="value.minWidth"
            />
        </el-table>

        <el-pagination v-model:current-page="currentPage" :page-size="results.per_page" :total="results.total" />
    </template>
    <template v-else>
        <el-empty description="No results" />
    </template>
</template>
