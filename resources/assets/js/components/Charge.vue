<template>
    <div class="container">
      <transition name="fade">
        <div class="row" v-if="ready">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Quick Charge</div>

                    <div class="panel-body">
                      <h2>Available Balance: {{balance.available}}</h2>
                      <br>
                      <h2>Pending Balance: {{balance.pending}}</h2>
                      <fieldset>
                        <legend>Payment</legend>
                        <div class="form-group">
                          <label class="col-sm-3 control-label" for="amount">Amount</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control"  v-model="amount" id="amount" placeholder="Charge Amount">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" autocomplete="cc-name" v-model="card.card_holder_name" id="card-holder-name" placeholder="Card Holder's Name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label" for="card-number">Card Number</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" autocomplete="cc-number" v-model="card.card_number" id="card-number" placeholder="Debit/Credit Card Number">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label" for="expiry-month">Expiration Date</label>
                          <div class="col-sm-9">
                            <div class="row">
                              <div class="col-xs-3">
                                <select class="form-control col-sm-2" autocomplete="cc-exp-month" v-model="card.expiry_month" id="expiry-month">
                                  <option>Month</option>
                                  <option value="01">Jan (01)</option>
                                  <option value="02">Feb (02)</option>
                                  <option value="03">Mar (03)</option>
                                  <option value="04">Apr (04)</option>
                                  <option value="05">May (05)</option>
                                  <option value="06">June (06)</option>
                                  <option value="07">July (07)</option>
                                  <option value="08">Aug (08)</option>
                                  <option value="09">Sep (09)</option>
                                  <option value="10">Oct (10)</option>
                                  <option value="11">Nov (11)</option>
                                  <option value="12">Dec (12)</option>
                                </select>
                              </div>
                              <div class="col-xs-3">
                                <select class="form-control" autocomplete="cc-exp-year" v-model="card.expiry_year">
                                  <option value="13">2013</option>
                                  <option value="14">2014</option>
                                  <option value="15">2015</option>
                                  <option value="16">2016</option>
                                  <option value="17">2017</option>
                                  <option value="18">2018</option>
                                  <option value="19">2019</option>
                                  <option value="20">2020</option>
                                  <option value="21">2021</option>
                                  <option value="22">2022</option>
                                  <option value="23">2023</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" autocomplete="cvc" v-model="card.cvv" id="cvv" placeholder="Security Code">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-3 col-sm-9">
                            <button type="button" class="btn btn-success" v-on:click="charge">Pay Now</button>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                </div>
            </div>
        </div>
      </transition>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
          return {
            card: {
              cvv: null,
              expiry_year: null,
              expiry_month: null,
              card_number: null,
              card_holder_name: null
            },
            amount: 0.00,
            vapid_public_key: null,
            registration: null,
            balance: {},
            ready: false
          }
        },
        props: ['vapidKey'],
        methods:{
          charge: function(){
            var that = this;
            axios.post('/api/quick-charge',{amount:this.amount,card:this.card}).then(function(data){
              that.card = {

                cvv: null,
                expiry_year: null,
                expiry_month: null,
                card_number: null,
                card_holder_name: null
              };
              axios.get('/api/balance').then(function(data){
                that.balance = data.data;
              });
            }).catch(function(error){
              alert(error.message);
            });
          },
          askPermission: function(){
            var that = this;
            return new Promise(function(resolve, reject) {
              const permissionResult = Notification.requestPermission(function(result) {
                resolve(result);
              });

              if (permissionResult) {
                permissionResult.then(resolve, reject);
              }
            })
            .then(function(permissionResult) {
              if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
              }
              else{
                that.subscribeUserToPush();
              }
            });
          },
          urlBase64ToUint8Array: function(base64String){
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
              .replace(/\-/g, '+')
              .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
              outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
          },
          getSWRegistration:function(){
            var that = this;
            var promise = new Promise(function(resolve, reject) {
            // do a thing, possibly async, then…

            if (that.registration != null) {
              resolve(that.registration);
            }
            else {
              reject(Error("It broke"));
            }
            });
            return promise;
          },
          subscribeUserToPush: function(){
            var that = this;
            this.getSWRegistration()
            .then(function(registration) {
              console.log(registration);
              const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: that.urlBase64ToUint8Array(
                  that.vapid_public_key
                )
              };

              return registration.pushManager.subscribe(subscribeOptions);
            })
            .then(function(pushSubscription) {
              console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
              that.sendSubscriptionToBackEnd(pushSubscription);
              return pushSubscription;
            });
          },
          sendSubscriptionToBackEnd:function(subscription){
            axios.post('/api/save-subscription',subscription).then(function(data){
              alert('Success');
            }).catch(function(error){
              alert(error.message);
            });
          },
          enableNotifications: function(){
            this.askPermission();
          }
        },
        created(){
          var that = this;
          axios.get('/api/balance').then(function(data){
            that.balance = data.data;
            that.ready = true;
          });
          this.vapid_public_key = this.vapidKey;
          var that = this;
          navigator.serviceWorker.register('service-worker.js')
          .then(function(registration) {
            console.log('Service worker successfully registered.');
            that.registration = registration;
            return registration;
          })
          .catch(function(err) {
            console.error('Unable to register service worker.', err);
          });
        }
    }
</script>
