<template>
    <div class="container">
      <transition name="fade">
        <div class="row" v-if="ready">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Customers</div>

                    <div class="panel-body">
                      <ul>
                        <li v-for="customer in subscriptions.data">{{customer.email}}</li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
      </transition>
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Add New Customer</div>

                  <div class="panel-body">
                    <input v-model="customer.email" placeholder="Customer Email" type="email" class="form-control"></input>
                    <select class="form-control" v-model="customer.plan">
                      <option v-for="plan in plans" v-model="plan.id" :value="plan.id">{{plan.name}}</option>
                    </select>
                    <button class="btn btn-sm btn-default" v-on:click="addCustomer">Send Subscription Email</button>
                  </div>
              </div>
          </div>
      </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
          return {
            subscriptions: {},
            ready: false,
            plans: [],
            customer: {
              email: '',
              plan: ''
            }
          }
        },
        props: [],
        methods:{
          addCustomer: function(){
            axios.post('/api/customer',{email:this.customer.email,plan_id:this.customer.plan}).then(function(data){
              console.log(data.data);
            }).catch(function(error){
              console.log(error.message);
            });
          }
        },
        created(){
          var that = this;
          axios.get('/api/subscriptions').then(function(data){
            that.subscriptions = data.data;
            that.ready = true;
          });
          axios.get('/api/plans').then(function(data){
            that.plans = data.data.data;

          });

        }
    }
</script>
