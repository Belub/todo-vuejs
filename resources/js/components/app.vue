<template>
    <div class="container text-center d-f mb-4">
        <add-item v-on:reloadlist="getItems()" />
        <list-view
            :items="items"
            v-on:reloadlist="getItems()"
            class="text-center"
        />
    </div>
</template>

<script>
import addItem from "./addItem";
import listView from "./listView";

export default {
    components: {
        addItem,
        listView,
    },

    data: function () {
        return {
            items: [],
        };
    },
    methods: {
        getItems() {
            axios
                .get("api/items")
                .then((res) => {
                    this.items = res.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    created() {
        this.getItems();
    },
};
</script>

<style scoped></style>
