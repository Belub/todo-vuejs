<template>
    <div class="container m-2 w-100">
        <input
            type="test"
            placeholder="add sub task"
            class="border"
            v-model="item.name"
        />
        <button
            :class="[item.name ? 'active' : 'notactive']"
            @click="addItem()"
        >
            ADD
        </button>
    </div>
</template>
<script>
export default {
    props: ["itemId"],
    data: function () {
        return {
            item: {
                name: "",
                id: this.itemId
            },
        };
    },
    methods: {
        addItem() {
            if (this.item.name == "") {
                return;
            }
            axios
                .post("api/sub_item/store", {
                    item: this.item,
                })
                .then((res) => {
                    if (res.status == 201) {
                        this.item.name = "";
                        this.$emit("reloadsublist", this.itemId);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>

<style scoped>
.active {
    color: white;
    background-color: blue;
}
.inactive {
    color: gray;
}
</style>
