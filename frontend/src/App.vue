<template>
	<div>
		<router-view v-slot="{ Component }">
			<component :is="Component" />
		</router-view>
	</div>
</template>

<script>
export default {
	data() {
		return {
			categories: [],
		};
	},
	components: {},
	methods: {
		async getCategories() {
			let res = await this.$axios.get("/api/categories");
			this.categories = res.data;
		},
	},
	mounted() {
		this.getCategories();
	},
};
</script>

<style></style>
