<template>
    <div class="w-100">
        <li
            :id="item.id"
            class="list-group-item d-flex justify-content-between flex-column w-100 h-25"
        >
            <div class="d-flex justify-content-between w-100">
                <input
                    type="checkbox"
                    @change.stop="updateCheckAll((checked = !checked))"
                    :checked="item.completed"
                    class="input__checkbox mr-3"
                />
                <span
                    :class="[item.completed ? 'completed' : '', 'item']"
                    >{{ item.name }}</span
                >
                <button class="btn-danger ml-3" @click="removeItem()">X</button>
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
    transition: opacity 0.1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
}
span {
    cursor: pointer;
}
</style>
