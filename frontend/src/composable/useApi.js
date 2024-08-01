// src/composables/useApi.js
import axios from 'axios';
import { ref } from 'vue';

export function useApi() {
    const data = ref(null);
    const error = ref(null);
    const loading = ref(false);

    const fetchData = async (url) => {
        loading.value = true;
        try {
            const response = await axios.get(url);
            data.value = response.data;
        } catch (err) {
            error.value = err;
        } finally {
            loading.value = false;
        }
    };

    return { data, error, loading, fetchData };
}
