export default {
    methods: {
        __(key, replace = {}) {
            // let translation = this.$page.props.language[key] ? this.$page.props.language[key] : key;
            // Object.keys(replace).forEach(function (key) {
            //     translation = translation.replace(':' + key, replace[key])
            // });
            // return translation

            return key;
        },

        formatPrice(value) {
            return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        },

        getImageUrl(text) {
            return window.location.origin + '/images/' + text;
        },
    },
}
