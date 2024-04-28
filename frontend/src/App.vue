<template>
	<div>
		<Home />
	</div>
</template>

<script>

import Home from './pages/Home.vue'

export default {
	data() {
		return {
			categories: []
		}
	},
	components: {
		Home
	},
	methods: {
		async getCategories() {
			let res = await this.$axios.get("/api/categories");
			this.categories = res.data;
		}
	},
	mounted() {
		this.getCategories();
	}
};
</script>

<style></style>
