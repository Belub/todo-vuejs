<template>
    <div class="w-100">
        <li
            :id="item.id"
            class="list-group-item d-flex justify-content-between flex-column w-100 h-25"
        >
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex w-100">
                    <input
                        type="checkbox"
                        @change.stop="updateCheckAll((checked = !checked))"
                        :checked="item.completed"
                        class="input__checkbox mr-3"
                    />
                    <span
                        :class="
                            [item.completed ? 'completed' : '', 'item'] +
                            ' ml-2'
                        "
                        >{{ item.name }}</span
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
            </div>
        </li>
        <transition name="fade">
            <div class="d-flex justify-content-between flex-column w-50 ml-4">
                <sub-item
                    :subItem="subItem"
                    :itemId="item.id"
                    v-for="subItem in subItems"
                    :key="`${item.id}_${subItem.id}`"
                    @subitemdeleted="updateSubItems"
                />
                <add-sub-item
                    :itemId="item.id"
                    @reloadsublist="updateSubItems"
                />
            </div>
        </transition>
    </div>
</template>

<script>
import subItem from "./subItem";
import addSubItem from "./addSubItem";

export default {
    components: {
        subItem,
        addSubItem,
    },
    props: ["item"],
    data: function () {
        return {
            subItems: [],
            checked: this.item.completed,
        };
    },
    mounted() {
        this.expandSubItem(this.item.id);
    },
    methods: {
        updateSubItems(itemId) {
            axios.get(`api/sub_item/${itemId}`).then((res) => {
                this.subItems = res.data;
                if (
                    res.data.reduce((acc, cur) => acc + cur.completed, 0) ===
                    res.data.length
                ) {
                    this.updateCheckAll(true);
                } else {
                    this.item.completed = false;
                    this.updateCheck();
                }
            });
        },
        expandSubItem(itemId) {
            axios.get(`api/sub_item/${itemId}`).then((res) => {
                this.subItems = res.data;
            });
        },
        updateCheck() {
            axios
                .put(`api/item/${this.item.id}`, {
                    item: this.item,
                })
                .then((res) => {
                    if (res.status === 200) this.$emit("itemchanged");
                })
                .catch((error) => {
                    console.error("error from axios put", errors);
                });
        },
        updateCheckAll(bool) {
            this.item.completed = bool;
            this.subItems.forEach((el) => {
                el.completed = bool;
            });
            axios
                .put(`api/item/all/${this.item.id}`, {
                    item: this.item,
                })
                .then((res) => {
                    if (res.status === 200) this.$emit("itemchanged");
                })
                .catch((error) => {
                    console.error("error from axios put", errors);
                });
        },
        removeItem() {
            axios
                .delete(`api/item/${this.item.id}`)
                .then((res) => {
                    if (res.status == 200) {
                        this.$emit("itemchanged");
                    }
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
    transition: opacity 2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
}
span {
    cursor: pointer;
}
</style>
