<template>
    <div class="mt-4">
        <h4>LIST TASKS</h4>
        <ul class="list-group d-flex justify-content-center align-items-center">
            <list-item
                :item="item"
                v-on:itemchanged="$emit('reloadlist')"
                v-for="item in items"
                :key="item.id"
                class="m-auto my-1 text-justify text-wrap"
            />
        </ul>
    </div>
</template>

<script>
import listItem from "./listItems";

export default {
    components: {
        listItem,
    },
    props: ["items"],
};
</script>

<style scoped></style>
