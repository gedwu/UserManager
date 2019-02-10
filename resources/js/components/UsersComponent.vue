<template>
    <div>
        <button type="button" class="btn btn-lg btn-primary" v-on:click="visible = !visible">
            <span v-if="!visible">Show</span>
            <span v-if="visible">Hide</span>
            Form
        </button>
        <div class="alert alert-success" v-if="success">
            {{success}}
        </div>
        <div v-if="visible">
            <form action="#" @submit.prevent="edit ? updateUser(user.id) : createUser()">
                <div class="form-group">
                    <label>Name</label>
                    <input v-model="user.name" type="text" name="name" class="form-control">
                    <span v-if="errors.name" class="alert alert-danger">{{ errors.name }}</span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input v-model="user.email" type="email" name="email" class="form-control">
                    <span v-if="errors.email" class="alert alert-danger">{{ errors.email }}</span>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input v-model="user.phone" type="text" name="phone" class="form-control">
                    <span v-if="errors.phone" class="alert alert-danger">{{ errors.phone }}</span>
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" v-model="user.gender" v-bind:value="'m'" checked>
                        Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" v-model="user.gender" v-bind:value="'f'">
                        Female
                    </label>
                    <span v-if="errors.gender" class="alert alert-danger">{{ errors.gender }}</span>
                </div>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" v-model="user.status" v-bind:value="1" checked>
                        Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" v-model="user.status" v-bind:value="0">
                        Inactive
                    </label>
                    <span v-if="errors.status" class="alert alert-danger">{{ errors.status }}</span>
                </div>
                <div class="form-group">
                    <button type="button" @click="randomizeUser()" class="btn btn-success">Randomize User</button>
                    <button v-show="!edit" type="submit" class="btn btn-primary">Add User</button>
                    <button v-show="edit" type="submit" class="btn btn-primary">Edit User</button>
                </div>
            </form>
        </div>
        <hr>
        <nav aria-label="Page navigation example"><!--Pagination start-->
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPaginatedUserList(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPaginatedUserList(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav><!--Pagination end-->

        <div class="container bootstrap snippet"> <!--Users table start-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-box no-header clearfix">
                        <div class="main-box-body clearfix">
                            <div class="table-responsive">
                                <table class="table user-list">
                                    <thead>
                                    <tr>
                                        <th><span>User</span></th>
                                        <th><span>Created</span></th>
                                        <th class="text-center"><span>Status</span></th>
                                        <th><span>Email</span></th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in list">
                                        <td>
                                            <img src="https://bootdey.com/img/Content/user_1.jpg" v-if="user.gender === 'm'">
                                            <img src="https://bootdey.com/img/Content/user_2.jpg" v-else-if="user.gender === 'f'">
                                            <img src="storage/notset.png" alt="" v-else>

                                            <a href="#" class="user-link">{{ user.name}} </a>
                                            <span class="user-subhead">{{ user.phone }}</span>
                                        </td>
                                        <td>{{ user.created_at }}</td>
                                        <td class="text-center">
                                            <span v-if="user.status" class="badge badge-success">Active</span>
                                            <span v-else class="badge badge-danger">Inactive</span>
                                            <!--<span class="badge badge-secondary">pending</span>-->
                                        </td>
                                        <td>
                                            <a href="#">{{ user.email }}</a>
                                        </td>
                                        <td style="width: 20%;">
                                            <a href="#" class="table-link">
                                                <span class="fa-stack">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="table-link">
                                                <span class="fa-stack" @click="showUser(user.id)">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="table-link danger">
                                                <span class="fa-stack" @click="deleteUser(user.id)">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--Users table end-->
    </div>
</template>

<script>
    import {settings} from "../const";

    export default {
        data: function(){
            return {
                settings:null,
                edit:false,
                visible:false,
                success: false,
                pagination: {},
                url:'api/users',
                list:[],
                errors: [],
                user: {
                    id:'',
                    name:'',
                    email:'',
                    gender:'n',
                    status:1,
                    created_at:''
                }
            }
        },
        mounted: function(){
            console.log('Users component loaded');
            this.settings = settings;
            this.fetchUsersList();
        },
        methods:{
            fetchUsersList: function(){
                console.log('Fetching Users');
                let $this = this;
                axios.get(this.url)
                    .then((response) => {
                        this.list = response.data['data'];
                        $this.makePagination(response.data['meta'], response.data['links']);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            createUser: function(){
                console.log('Creating User');
                this.errors = [];
                let self = this;
                let params = Object.assign({}, self.user);
                axios.post('api/user', params)
                    .then(function (response) {
                        if (response.status == 200) {
                            console.log(response.data.success);
                            self.success = response.data.success;
                        }
                    })
                    .then(function(){
                        self.user.name = '';
                        self.user.email = '';
                        self.user.phone = '';
                        self.user.gender = 'n';
                        self.user.status = 1;
                        self.edit = false;
                        self.fetchUsersList();
                    })
                    .catch(function(error){
                        if (error.response.status == 422) {
                            self.errors = error.response.data.errors;
                            console.log(error.response.data.errors);
                        }
                    })
            },
            showUser: function(id){
                this.errors = [];
                this.visible= 1;
                this.success=0;
                console.log('Fetching User with id '+id+' information');
                let self = this;
                axios.get('api/user/'+id)
                    .then(function(response){
                        self.user.id = response.data['data'].id;
                        self.user.name = response.data['data'].name;
                        self.user.email = response.data['data'].email;
                        self.user.phone = response.data['data'].phone;
                    });
                self.edit = true;
            },
            randomizeUser: function(){
                this.errors = [];
                this.success = 0;
                let self = this;
                let id = Math.floor(Math.random() * 10) + 1;
                fetch(this.settings.RANDOM_USER_URL+id)
                    .then(response => response.json())
                    .then(json => {
                        console.log(json);
                        self.user.name = json.name;
                        self.user.email = json.email;
                        self.user.phone = json.phone;
                    });
            },
            updateUser: function(id){
                console.log('Updating User with id '+id);
                this.errors = '';
                let self = this;
                let params = Object.assign({}, self.user);
                axios.put('api/user/'+id, params)
                    .then(function (response) {
                        if (response.status == 200) {
                            console.log(response.data.success);
                            self.success = response.data.success;
                        }
                    })
                    .then(function(){
                        self.user.name = '';
                        self.user.email = '';
                        self.user.phone = '';
                        self.edit = false;
                        self.fetchUsersList();
                    })
                    .catch(function(error){
                        if (error.response.status == 422) {
                            self.errors = error.response.data.errors;
                            console.log(error.response.data.errors);
                        }
                    })
            },
            deleteUser: function(id){
                this.visible= 0;
                let self = this;
                console.log('Deleting user with id: '+id);
                axios.delete('api/user/'+id)
                    .then(function(response){
                        self.fetchUsersList();
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },
            fetchPaginatedUserList(url) {
                this.url = url;
                this.fetchUsersList();
            }
        }
    }
</script>
