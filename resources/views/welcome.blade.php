<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>In-App-Purchase Model</title>
        <script src="//cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
        <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="//bootswatch.com/5/zephyr/bootstrap.min.css">
    </head>
    <body>
        <div id="app">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-4">
                        <div class="card mb-4">
                            <div class="card-header">Register a Device</div>
                            <div class="card-body">
                                App ID
                                <select class="form-control mb-3" v-model="device.app_id">
                                    <option :key="app.id" v-for="app in apps" :value="app.id">@{{ app.title }}</option>
                                </select>
                                Device ID
                                <input type="text" class="form-control mb-3" v-model="device.uid">
                                Language
                                <select class="form-control mb-3" v-model="device.language">
                                    <option v-for="language in languages" :value="language.id">@{{ language.title }}</option>
                                </select>
                                Operating System
                                <select class="form-control mb-3" v-model="device.os">
                                    <option v-for="o in os" :value="o.id" :selected="o.id === device.os">@{{ o.title }}</option>
                                </select>
                                Timezone
                                <select class="form-control mb-3" v-model="device.timezone">
                                    <option :key="timezone.id" v-for="timezone in timezones" :value="timezone.id">@{{ timezone.title }}</option>
                                </select>
                                <button class="btn btn-primary" v-on:click="registerDevice">Register</button>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">New Purchase</div>
                            <div class="card-body">
                                Client Token
                                <input type="text" class="form-control mb-3" v-model="client.token">
                                Receipt
                                <select class="form-control mb-3" v-model="client.receipt">
                                    <option :key="index" v-for="(receipt, index) in fakeReceipes" :value="receipt">@{{ receipt }}</option>
                                </select>
                                <button class="btn btn-primary" v-on:click="newPurchase">Purchase</button>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Subscription Status</div>
                            <div class="card-body">
                                Client Token
                                <input type="text" class="form-control mb-3" v-model="client.token">
                                Expire Date
                                <input type="text" class="form-control mb-3" v-model="client.expire" readonly>
                                <button class="btn btn-primary" v-on:click="checkSubscription">Re-check</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card mb-4">
                            <div class="card-header">Last Device Registrations</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" v-for="device in devices">
                                        <span class="badge bg-primary">device registered</span><br />
                                        <small class="text-muted">
                                        Created At: @{{ device.created_at }} UTC<br />
                                        AppId: @{{ device.app_id }}<br />
                                        UID: @{{ device.uid }}<br />
                                        Token: @{{ device.token }}
                                        </small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>

    new Vue({
        el: '#app',
        data: {
            device : {
                timezone: 16,
                app_id: 1,
                uid: '1234-5678-1234-5678',
                language: 1,
                os: 1,
            },
            client : {
                token: null,
                receipt: 767482564265746,
                expire: null,
                status: 1,
            },
            languages : [
                {'id': 1, 'title': 'Turkish'},
                {'id': 2, 'title': 'English'}
            ],
            os: [
                {'id': 1, 'title' : 'iOS'},
                {'id': 2, 'title' : 'Android'}
            ],
            fakeReceipes: [
                767482564265746,
                767482564265747,
                767482564265748,
                767482564265749,
                767482564265750,
            ],
            apps : [],
            timezones : [],
            devices : [],
        },
        methods : {
            getApps: function(){
                let _this = this;
                axios.get('/api/getApps')
                .then(function (response) {
                    _this.apps = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getTimezones: function(){
                let _this = this;
                axios.get('/api/getTimezones')
                .then(function (response) {
                    _this.timezones = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getRegisteredDevices: function(){
                let _this = this;
                axios.get('/api/getRegisteredDevices', this.device)
                .then(function (response) {
                    console.log(response.data);
                    _this.devices = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registerDevice: function(){
                let _this = this;
                axios.post('/api/registerDevice', this.device)
                .then(function (response) {
                    console.log(response);
                    _this.client.token = response.data.token;
                    _this.getRegisteredDevices();
                    Swal.fire({
                        title: 'Good Job!',
                        html: response.data.message + '<br /><br />Your token is: ' + response.data.token,
                        icon: 'success',
                        confirmButtonText: 'Close',
                    }).then((result) => {
                        _this.checkSubscription();
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            newPurchase: function(){
                let _this = this;
                axios.post('/api/newPurchase', this.client)
                .then(function (response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Great Job!',
                        html: response.data.message,
                        icon: 'success',
                        confirmButtonText: 'Close'
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        title: 'Opps!',
                        html: error.response.data.message,
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                });
            },
            checkSubscription: function(){
                let _this = this;
                axios.post('/api/checkSubscription', 'token=' + _this.client.token + '&status=' + _this.client.status)
                .then(function (response) {
                    _this.client.expire = response.data.expire;
                    console.log(response);
                    if(response.data.status == true)
                    {
                        Swal.fire({
                            title: 'Active Subscription!',
                            html: 'Your subscription expiry date is:<br />' + response.data.expire + ' ' + response.data.timezone,
                            icon: 'success',
                            confirmButtonText: 'Close'
                        });
                    }
                    else
                    {
                        Swal.fire({
                            title: 'Inactive Subscription!',
                            html: 'Your subscription is unavailable',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(function (error) {
                    Swal.fire({
                        title: 'Opps!',
                        html: error.response.data.message,
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                });
            },
        },
        mounted: function()
        {
            this.getRegisteredDevices();
            this.getApps();
            this.getTimezones();
        }
    })
    </script>
    </body>
</html>
