import filtersConfig from './filtersConfig';

export default {
    submitUrl: {
        type: String,
        required: true
    },
    errors: {
        type: Object,
        default: () => {}
    },
    results: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true,
        validator(value) {
            return Object.keys(value)
                .map(key => {
                    return filtersConfig[key]?.validate(value[key]);
                })
                .every(Boolean);
        }
    }
};
