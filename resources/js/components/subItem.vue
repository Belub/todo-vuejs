<template>
    <li class="list-group-item d-flex justify-content-between w-100">
        <div class="d-flex w-100">
            <input
                type="checkbox"
                @change.stop="updateCheck()"
                :checked="subItem.completed"
                class="input__checkbox mr-3"
            />
            <span
                :class="[subItem.completed ? 'completed ml-2' : '', 'item ml-2']"
                >{{ subItem.name }}</span
            >
        </div>
        <button class="btn-danger ml-3" @click="removeItem()">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-trash"
                viewBox="0 0 16 16"
            >
                <path
                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                />
                <path
                    fill-rule="evenodd"
                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                />
            </svg>
        </button>
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
                    if (res.status === 200)
                        this.$emit("subitemdeleted", this.itemId);
                })
                .catch((error) => {
                    console.error("error from axios put", errors);
                });
        },
        removeItem() {
            axios
                .delete(`api/sub_item/${this.subItem.id}`)
                .then((res) => {
                    if (res.status === 200)
                        this.$emit("subitemdeleted", this.itemId);
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
