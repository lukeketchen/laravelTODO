

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg drop-shadow">
                    <div class="flex justify-between px-4 py-8 border-b drop-shadow">
                        <div class="w-full mr-4">
                            <input 
                            type="text" 
                            v-model="newTodo" 
                            placeholder="Add Todo here..."
                            class="w-full rounded" />
                        </div>
                        <div class="flex">
                            <button class="border bg-blue-500 text-white rounded py-1 px-4 font-bold" @click="addTodo">
                                Add
                            </button>
                        </div>
                    </div>
                    <div v-for="todo in todos" class="flex justify-between py-2 border-b px-4 mx-2">
                        <div class="flex items-center" :class="(todo.completed ? 'line-through bg-red-100' : '')">
                        {{ todo.name }}</div>
                        <div class="">
                            <button class="border rounded py-1 px-2 mr-4" @click="completeTodo(todo)">
                                {{ todo.completed === 1 ? 'un-Check' : 'Done' }}
                            </button>
                            <button class="border rounded py-1 px-2" @click="deleteTodo(todo)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
   components: {
    AuthenticatedLayout,
    Head,
},
data() {
    return {
        loading: false,
        todos: {},
        meta: {},
        pageEditable: false,
        newTodo: '',
    };
},
mounted() {
    this.getTodos();
},
methods: {
    getTodos() {
        this.loading = true;
        axios
        .get("/api/todo/")
        .then((response) => {
            this.meta = response;
            this.todos = response.data;
        })
        .catch((error) => console.log(error))
        .finally(() => (this.loading = false));
    },
    completeTodo(todo){
        if(todo.completed){
            todo.completed = 0;
        } else{
            todo.completed = 1;
        }
        this.loading = true;
        axios.put("/api/todo/" + todo.id, todo)
        .then((response) => {
            this.getTodos();
        })
        .catch((error) => console.log(error))
        .finally(() => (this.loading = false));
    },
    deleteTodo(todo){
        this.loading = true;
        axios.delete("/api/todo/" + todo.id)
        .then((response) => {
            this.getTodos();
        })
        .catch((error) => console.log(error))
        .finally(() => (this.loading = false));
    },
    addTodo(){
        this.loading = true;
        let payload = {
            'name' : this.newTodo
        };

        axios.post("api/todo/",payload)
        .then((response) => {
            this.getTodos();
            this.newTodo = '';
        })
        .catch((error) => console.log(error))
        .finally(() => (this.loading = false));

    },
},
};
</script>