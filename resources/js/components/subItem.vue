<template>
    <li
        class="list-group-item d-flex justify-content-between w-100"
    >
        <input
            type="checkbox"
            @change.stop="updateCheck()"
            :checked="subItem.completed"
            class="input__checkbox mr-3"
        />
        <span :class="[subItem.completed ? 'completed' : '', 'item']">{{
            subItem.name
        }}</span>
        <button class="btn-danger ml-3" @click="removeItem()">X</button>
    </li>
</template>

<script>
export default {
    props: ["itemId", "subItem"],
    methods: {
        updateCheck() {
            axios
                .put(`api/sub_item/${this.subItem.id}`, {
                    item: this.subItem,
                })
                .then((res) => {
                    if (res.status === 200) this.$emit("subitemdeleted", this.itemId);
                })
                .catch((error) => {
                    console.error("error from axios put", errors);
                });
        },
        removeItem() {
            axios
                .delete(`api/sub_item/${this.subItem.id}`)
                .then((res) => {
                    if (res.status === 200) this.$emit("subitemdeleted", this.itemId);
                })
                .catch((error) => {
                    console.error("error from axios delte ", error);
                });
        },
    },
};
</script>

<style>
.completed {
    text-decoration: line-through;
    color: gray;
}
.item {
    word-break: break-all;
}
.input__checkbox {
    width: 25px;
    height: 25px;
    cursor: pointer;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 10s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
}
</style>
