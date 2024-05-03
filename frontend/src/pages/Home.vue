<template>
	<div>
		<header>
			<nav
				class="flex justify-between items-center h-[80px] border-b xl:px-[80px] md:px-[50px] px-[20px]"
			>
				<div>
					<router-link
						:to="{ name: 'home' }"
						class="text-3xl text-green-400 font-semibold"
						>My Recipe</router-link
					>
				</div>
				<div>
					<router-link
						:to="{ name: 'form' }"
						class="px-3 py-3 rounded-lg bg-red-400 hover:opacity-[0.85] transition-all duration-500 text-white flex items-center gap-2"
					>
						<i class="fa-solid fa-plus"></i>
						<div>Add Recipe</div>
					</router-link>
				</div>
			</nav>
		</header>

		<main class="xl:px-[80px] md:px-[50px] px-[20px]">
			<h1
				class="text-center mt-11 text-5xl font-bold text-gray-800 leading-tight"
			>
				All your favorite <span class="font-bold text-red-400">recipes,</span
				><br />
				<span class="font-bold text-red-400">in one place</span>
			</h1>

			<div class="justify-center md:flex hidden">
				<nav class="bg-red-400 text-white grid grid-flow-col text-center mt-14">
					<div
						class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3 active"
						@click="filterRecipeByCategory()"
					>
						All recipes
					</div>
					<div
						class="cursor-pointer hover:bg-white hover:text-red-400 transition-all duration-500 w-[120px] p-3"
						v-for="category in categories" :key="category.id"
						@click="filterRecipeByCategory(category.name)"
					>
						{{ category.name }}
					</div>
				</nav>
			</div>

			<div class="justify-center mt-11 block md:hidden">
				<select
					class="appearance-none bg-red-400 text-white outline-none border-none p-3 w-[300px] text-center"
					name=""
					id=""
				>
					<option>All Recipes</option>
					<option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
				</select>
			</div>

			<!-- recipe -->
			<div class="my-20 grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-12">
				<div v-if="!gettingRecipes" v-for="recipe in recipes" :key="recipe.id">
					<router-link :to="{ name: 'detail', params: { id: recipe.id} }">
						<div
							class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg active:shadow-none transition-all duration-500 max-h-[600px]"
						>
							<img
								class="h-[300px] mb-4 rounded-t-lg w-full object-cover"
								:src="recipe.photo"
								alt="product image"
							/>
							<div class="px-5 pb-5">
								<h5
									class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white line-clamp-1"
								>
									{{ recipe?.title }}
								</h5>
								<p class="line-clamp-2 mt-2 text-gray-500">
									{{ recipe?.description }}
								</p>
							</div>
						</div>
					</router-link>
				</div>
				<div v-else v-for="(v, index) in new Array(6)" :key="index">
					<div
						class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-lg active:shadow-none transition-all duration-500 max-h-[600px] animate-pulse">
						<div class="h-[300px] mb-4 rounded-t-lg w-full object-cover bg-slate-700" />
						<div class="px-5 pb-5 bg-slate-700">
							<div class="h-[5px] bg-slate-700" />
							<div class="h-[5px] mt-2 bg-slate-700"> </div>
							<div class="h-[5px] w-[80%] mt-1 bg-slate-700"></div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</template>

<script>
export default {
    data() {
        return {
            recipes: [],
			categories: [],
			gettingRecipes: true,
        }
    },
    methods: {
        async getRecipes() {
            try {

                let res = await this.$axios.get('/api/recipes');
                if (res) {
                    this.recipes = res.data.data;
					this.gettingRecipes = false;
                }

            } catch (e) {
                console.log(e);
            }
        },
		async getCategories() {
            try {

                let res = await this.$axios.get('/api/categories');
                if (res) {
                    this.categories = res.data;
					console.log(this.categories);
                }

            } catch (e) {
                console.log(e);
            }
        },
		async filterRecipeByCategory(category = "") {
			try {

                let res = await this.$axios.get('/api/recipes?category=' + category);
                if (res) {
                    this.recipes = res.data.data;
                }

            } catch (e) {
                console.log(e);
            }
		}
    },
    mounted() {
        this.getRecipes();
		this.getCategories();
    }
}
</script>

<style>

</style>