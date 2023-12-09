export default {
    name: {
        defaultValue: null,
        validate: val => val === null || typeof val === 'string'
    },
    bedrooms: {
        defaultValue: null,
        validate: val => val === null || Number.isInteger(val)
    },
    bathrooms: {
        defaultValue: null,
        validate: val => val === null || Number.isInteger(val)
    },
    storeys: {
        defaultValue: null,
        validate: val => val === null || Number.isInteger(val)
    },
    garages: {
        defaultValue: null,
        validate: val => val === null || Number.isInteger(val)
    },
    price: {
        defaultValue: null,
        validate: val => {
            return val === null || (Array.isArray(val) && val.length === 2 && val.every(v => Number.isInteger(v)));
        }
    }
};
