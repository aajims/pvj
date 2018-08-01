<template>
    <div id="page-wrapper" class="sms">
        <div class="container-fluid">
            <div class="row head-page">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1>SMS Report</h1>
                        <div class="btn-sms pull-right">
                            <button class="btn btn-warning" v-if="searching" v-on:click="downloadPDF2">Download PDF</button>
                            <button class="btn btn-filter" data-toggle="modal" data-target="#filterModal">Search Filter <i class="fa fa-sliders"></i> </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="alert alert-danger" v-if="errors" v-for="error in errors">
                        <p>{{ error }}</p>
                    </div>
                    <div class="alert alert-info" v-if="searching && ! (errors.length > 0)">
                        <p>Anda sedang mencari data berdasarkan RECEIVER  "{{ receiver }}"
                            <!--<button class="btn btn-warning pull-right" v-on:click="resetFilter()">Batalkan filter</button>-->
                        </p>
                        <div class="clearfix"></div>
                    </div>
                    <!--api-url="http://192.168.2.20:8005/sms/smsFilter"-->
                    <!--api-url="http://192.168.2.20:8005/sms/smsTest"-->
                    <!--v-bind:api-url="APIUrl + '/sms'"-->
                    <div id="printTable">
                        <vuetable ref="vuetable"
                                api-url="http://192.168.2.20:8005/sms/smsTest"
                                  v-bind:fields="fields"
                                  pagination-path=""
                                  v-bind:css="css.table"
                                  v-bind:sort-order="sortOrder"
                                  v-bind:multi-sort="true"
                                  v-bind:http-options = "options"

                                  :append-params="moreParams"
                                  @vuetable:pagination-data="onPaginationData">

                        </vuetable>
                    </div>
                    <vuetable-pagination ref="pagination"
                                         :css="css.paginations"
                                         @vuetable-pagination:change-page="onChangePage">
                    </vuetable-pagination>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="filterModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Search Filter</h4>
                    </div>
                    <div class="modal-body">
                        <form class="mdl-filter" v-on:submit="filter()">
                            <img src="../img/phone.png" class="Phone">
                            <div class="styleds-input agile-styleds-input-top" @key.enter="doFilter">
                                <input type="text" class="disab" name="receiver" disabled v-model="receiver"/>
                                <label>Receiver Number (MSISDN)</label>
                                <span></span>
                            </div>
                            <div class="row">
                                <!-- <label for="">Date range</label> -->
                                <div class="col-md-6">
                                    <img src="../img/calendar.png"/>
                                    <date-picker class="form-controls" id="starDate" v-model="startDate" :config="config" placeholder="Start Date" ></date-picker>
                                    <span>{{ msgStart }}</span>
                                </div>
                                <div class="col-md-6">
                                    <img src="../img/calendar.png"/>
                                    <date-picker class="form-controls" id="endDate" v-model="endDate" :config="config" placeholder="End Date" aria-required="true"></date-picker>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <template v-if="startDate == null || endDate == null || startDate >= endDate">
                            <button type="button" @click="doFilter" class="Btn-Filter-disable" disabled="" data-dismiss="modal"><p class="Search">Search <i class="fa fa-search src"></i></p></button>
                        </template>
                        <template v-else>
                            <button type="button" @click="doFilter" class="Btn-Filter" data-dismiss="modal"><p class="Search">Search <i class="fa fa-search src"></i></p></button>
                        </template>
                        <!--<button type="button" @click="doFilter" class="Btn-Filter" data-dismiss="modal"><p class="Search">Search <i class="fa fa-search src"></i></p></button>-->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';

    // Import this component
    import DatePicker from 'vue-bootstrap-datetimepicker';
    // Import date picker css
    import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';


    export default {
        mounted() {
            let now = new Date()
            let nowDate = now.getFullYear() + '-' +
                (now.getMonth() + 1) + '-' +
                now.getDate() + ' ' +
                now.getHours() + ':' +
                now.getMinutes()
            this.startDate = nowDate
            this.endDate = nowDate
            this.receiver = this.$auth.user().telepon

            this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
            this.$events.$on('filter-reset', e => this.onFilterReset())
        },
        created() {
            this.receiver = this.$auth.user().telepon
            this.success = JSON.parse(
                window.localStorage.getItem('success')
            );
            window.localStorage.removeItem('success');
        },
        components: {
            Vuetable,
            VuetablePagination,
            DatePicker
        },
        data: function() {
            return {
                date: new Date(),
                config: {
                    format: 'YYYY-MM-DD HH:mm',
                    useCurrent: false,
                    sideBySide: true,

                },
                startDate: null,
                endDate: null,
                receiver: null,
                msgStart: '',
                errors: [],
                searching: false,

                success: [],
                deleteInfo: [],
                options: {
                    headers: {
                        Authorization: 'Bearer ' + window.localStorage.getItem('default_auth_token')
                    }
                },
                fields: [{
                    name: 'id',
                    title: 'ID',
                    titleClass: 'hidden',
                    dataClass: 'hidden table-id-row',
                    sortField: 'id'
                },{
                    name: 'received',
                    sortField: 'received',
                    title: 'Received'
                },{
                    name: 'amount',
                    sortField: 'amount',
                    title: 'Amount (Rp)'
                },{
                    name: 'receiver',
                    sortField: 'receiver',
                    title: 'Receiver'
                },{
                    name: 'msisdn',
                    sortField: 'msisdn',
                    title: 'MSISDN'
                }],
                css: {
                    table: {
                        tableClass: 'table table-bordered table-hover sms-table',
                        ascendingIcon: 'fa fa-angle-up',
                        descendingIcon: 'fa fa-angle-down'
                    },
                    paginations: {
                        wrapperClass: 'paginations',
                        activeClass: 'active',
                        disabledClass: '',
                        pageClass: 'page-item',
                        linkClass: 'page-item',
                        icons: {
                            first: 'fa fa-angle-double-left',
                            prev: 'fa fa-angle-left',
                            next: 'fa fa-angle-right',
                            last: 'fa fa-angle-double-right',
                        },
                    },
                    icons: {
                        first: 'glyphicon glyphicon-step-backward',
                        prev: 'glyphicon glyphicon-chevron-left',
                        next: 'glyphicon glyphicon-chevron-right',
                        last: 'glyphicon glyphicon-step-forward',
                    }
                },
                sortOrder: [{
                    field: 'id',
                    sortField: 'id',
                    direction: 'asc'
                }
                ],
                moreParams: {
                    receiver: this.$auth.user().telepon
                }
            };
        },
//        computed: {
//            resetFilter () {
//                this.searching = false
//                this.receiver = null  // clear the text in text input
//                this.startDate = null
//                this.endDate = null
//                this.$events.fire('filter-reset')
//            }
//        },
        methods: {
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                // this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            doFilter () {
                this.searching = true
                this.$events.fire('filter-set', JSON.stringify({
                    receiver: this.receiver,
                    startDate: this.startDate,
                    endDate: this.endDate
                }))
            },
            resetFilter () {
                this.receiver = null  // clear the text in text input
                this.startDate = null
                this.endDate = null
                this.$events.fire('filter-reset')
            },
            onFilterSet (str) {
                let data = JSON.parse(str)
                // reset error
                this.errors = []
                if (data.receiver == null) {
                    this.errors.push('Filter: Receiver tidak boleh kosong')
                    return
                } else if (data.startDate == null) {
                    this.errors.push('Filter: Tanggal mulai tidak boleh kosong')
                    return
                } else if(data.endDate == null) {
                    this.errors.push('Filter: Tanggal selesai tidak boleh kosong')
                    return
                }

                let startDate = data.startDate.toString().split(' ')
                let startDateTime = startDate[1].split(':')
                startDate = startDate[0].split('-')

                let sDate = new Date(
                    startDate[0], // year
                    startDate[1]-1,  // month, start from 0
                    startDate[2], // day
                    startDateTime[0], // hours
                    startDateTime[1] // minute
                )

                let endDate = data.endDate.toString().split(' ')
                let endDateTime = endDate[1].split(':')
                endDate = endDate[0].split('-')

                let eDate = new Date(
                    endDate[0], // year
                    endDate[1]-1,  // month, start from 0
                    endDate[2], // day
                    endDateTime[0], // hours
                    endDateTime[1] // minute
                )

                if (eDate.getTime() <= sDate.getTime()) {
                    this.errors.push('Filter: Range waktu harus benar, tanggal berakhir tidak boleh lebih dari tanggal dimulai')
                    return
                }

                this.moreParams = {
                    'receiver': this.$auth.user().telepon,
                    'start-date': data.startDate,
                    'end-date': data.endDate
                }


                let vm = this
                Vue.nextTick( function() {
                    vm.$refs.vuetable.refresh()
                })
            },
            onFilterReset () {
                this.moreParams = {}
                let vm = this
                Vue.nextTick( function() {
                    vm.$refs.vuetable.refresh()
                })
            },
            downloadPDF2(){
                window.open(baseUrl() + '/sms/download-pdf?receiver='+this.$auth.user().telepon+'&startDate='+this.startDate+'&endDate='+this.endDate,
                    "_blank")
            },
            downloadPDF() {
                // this.savedID = document.getElementsByClassName('table-id-row')
                let el = document.getElementsByClassName('table-id-row')
                let queryData = '?';
                for (var i = 0; i < el.length-1; i++) {
                    queryData += 'data[]=' + el[i].innerText + '&'
                }
                // Remove last &
                queryData = queryData.replace(/(^\s*&)|(&\s*$)/g, '')
                window.open(baseUrl() + '/sms/download-pdf' + queryData,
//                    this.$http(baseUrl() + '/sms/download-pdf' + queryData,
                    "_blank",
                    "width=800,height=500",  false)
            }
        }
    }
</script>
