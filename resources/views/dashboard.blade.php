@extends('layouts.app')

@section('title', $operation->name . ' - Aeon Finance')

@section('header_title')
<div class="flex items-center gap-4">
    <h1 class="text-2xl md:text-[3.5rem] font-headline font-bold text-on-surface leading-tight tracking-tight">{{ $operation->name }}</h1>
</div>
@endsection

@section('content')
<div x-data="dashboardApp()" x-init="init()" class="max-w-[1600px] mx-auto space-y-10 text-right">
    <!-- Header Section -->
    <div class="flex flex-row-reverse justify-between items-center mb-6">
        <div class="text-right">
            <p class="text-on-surface-variant font-body text-sm md:text-base">تفاصيل المعاملات المالية لهذه العملية المحددة.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-primary hover:underline text-sm font-bold flex items-center gap-1 flex-row-reverse group transition-all">
            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_back</span>
            الرجوع للقائمة الرئيسية
        </a>
    </div>

    <!-- Summary Cards (Bento Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group border border-slate-100">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors duration-500"></div>
            <div class="flex flex-row-reverse justify-between items-start mb-4 relative z-10">
                <div class="p-3 bg-surface-container-low rounded-xl text-primary group-hover:bg-primary/10 transition-colors">
                    <span class="material-symbols-outlined">attach_money</span>
                </div>
            </div>
            <div class="relative z-10 text-right">
                <p class="text-sm text-on-surface-variant font-body font-medium mb-1.5">مجموع الدولار</p>
                <p class="text-3xl font-headline font-bold text-on-surface tracking-tight" x-text="'$ ' + formatNumber(stats.total_dollar)">$ --</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group border border-slate-100">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-tertiary-container/5 rounded-full blur-2xl group-hover:bg-tertiary-container/10 transition-colors duration-500"></div>
            <div class="flex flex-row-reverse justify-between items-start mb-4 relative z-10">
                <div class="p-3 bg-surface-container-low rounded-xl text-tertiary-container group-hover:bg-tertiary-container/10 transition-colors">
                    <span class="material-symbols-outlined">currency_yuan</span>
                </div>
            </div>
            <div class="relative z-10 text-right">
                <p class="text-sm text-on-surface-variant font-body font-medium mb-1.5">مجموع الرنمينبي</p>
                <p class="text-3xl font-headline font-bold text-on-surface tracking-tight" x-text="'¥ ' + formatNumber(stats.total_rmb)">¥ --</p>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group border border-slate-100">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-secondary/5 rounded-full blur-2xl group-hover:bg-secondary/10 transition-colors duration-500"></div>
            <div class="flex flex-row-reverse justify-between items-start mb-4 relative z-10">
                <div class="p-3 bg-surface-container-low rounded-xl text-secondary group-hover:bg-secondary/10 transition-colors">
                    <span class="material-symbols-outlined">receipt_long</span>
                </div>
            </div>
            <div class="relative z-10 text-right">
                <p class="text-sm text-on-surface-variant font-body font-medium mb-1.5">مجموع الدفوعات</p>
                <p class="text-3xl font-headline font-bold text-on-surface tracking-tight" x-text="'¥ ' + formatNumber(stats.total_payments)">¥ --</p>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group border border-slate-100">
            <div class="absolute top-0 right-0 w-1.5 h-full bg-primary/20"></div>
            <div class="flex flex-row-reverse justify-between items-start mb-4 relative z-10">
                <div class="p-3 bg-surface-container-low rounded-xl text-primary-container group-hover:bg-primary-container/10 transition-colors">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
            </div>
            <div class="relative z-10 text-right">
                <p class="text-sm text-on-surface-variant font-body font-medium mb-1.5">المجموع الباقي</p>
                <p class="text-3xl font-headline font-bold text-primary tracking-tight" x-text="'¥ ' + formatNumber(stats.remaining)">¥ --</p>
            </div>
        </div>
    </div>

    <!-- Data Table Section (Full Width Desktop Style) -->
    <div class="bg-white rounded-[2rem] overflow-hidden shadow-[0_4px_30px_rgba(0,0,0,0.03)] border border-slate-100">
        <div class="p-8 pb-4 flex flex-row-reverse justify-between items-center">
            <h2 class="text-2xl font-headline font-bold text-teal-900">سجل التحويلات لـ {{ $operation->name }}</h2>
            <div class="flex gap-4">
                <button class="flex items-center gap-2 teal-gradient text-white px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-md shadow-primary/10" @click="addRecord()">
                    <span class="material-symbols-outlined text-lg">add</span>
                    إضافة سجل جديد
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto pb-4">
            <table class="w-full text-right font-body text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-teal-800 sticky top-0 z-10 border-y border-slate-100">
                    <tr>
                        <th class="px-6 py-5 font-bold w-16 text-center">أدوات</th>
                        <th class="px-6 py-5 font-bold">مبلغ محول دولار ($)</th>
                        <th class="px-6 py-5 font-bold">تاريخ التحويل</th>
                        <th class="px-6 py-5 font-bold">سعر الصرف RMB</th>
                        <th class="px-6 py-5 font-bold">مبلغ محول رنمينبي (¥)</th>
                        <th class="px-6 py-5 font-bold">دفع محلات</th>
                        <th class="px-6 py-5 font-bold">تفاصيل دفع المحلات</th>
                        <th class="px-6 py-5 font-bold">مبلغ المشتريات</th>
                        <th class="px-6 py-5 font-bold">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-on-surface">
                    <template x-for="(record, index) in records" :key="record.id">
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4 text-center">
                                <button @click="saveRecord(record)" class="w-8 h-8 flex items-center justify-center rounded-lg text-teal-600 hover:bg-teal-50 transition-all" title="حفظ التعديلات">
                                    <span class="material-symbols-outlined text-lg">save</span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" step="0.01" x-model="record.dollar_amount" @input="updateRmb(record)" class="w-32 bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-right font-bold text-teal-900 text-base">
                            </td>
                            <td class="px-6 py-4">
                                <input type="date" x-model="record.transaction_date" class="bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-right text-xs text-slate-500 font-medium">
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" step="0.0001" x-model="record.exchange_rate" @input="updateRmb(record)" class="w-24 bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-right text-sm font-semibold text-slate-700">
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-headline font-bold text-primary text-base" x-text="'¥ ' + formatNumber(record.rmb_amount)"></span>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" step="0.01" x-model="record.shop_payment" class="w-28 bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-right font-bold text-slate-700">
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" x-model="record.shop_details" class="w-48 bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-right text-sm placeholder-slate-300" placeholder="اسم المورد أو المحل...">
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" step="0.01" x-model="record.purchase_amount" class="w-28 bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-right font-bold text-slate-700">
                            </td>
                            <td class="px-6 py-4">
                                <select x-model="record.status" class="bg-transparent border-none focus:ring-2 focus:ring-primary/10 rounded-lg text-xs font-bold p-1 text-center"
                                        :class="record.status === 'completed' ? 'text-green-600' : 'text-amber-500'">
                                    <option value="pending">قيد المعالجة</option>
                                    <option value="completed">مكتمل</option>
                                </select>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards View -->
    <div class="md:hidden space-y-4">
        <template x-for="(record, index) in records" :key="record.id">
            <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-slate-100 space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-slate-50">
                    <span class="text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-full" x-text="'ID: ' + record.id"></span>
                    <input type="date" x-model="record.transaction_date" class="text-sm font-medium text-slate-400 bg-transparent border-none p-0 text-left">
                </div>
                <div class="grid grid-cols-2 gap-6 text-right">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">المحول ($)</p>
                        <input type="number" x-model="record.dollar_amount" @input="updateRmb(record)" class="w-full bg-transparent border-none p-0 text-lg font-black text-teal-900">
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">سعر الصرف</p>
                        <input type="number" x-model="record.exchange_rate" @input="updateRmb(record)" class="w-full bg-transparent border-none p-0 text-lg font-bold text-slate-700">
                    </div>
                    <div class="col-span-2 bg-slate-50 p-4 rounded-xl flex justify-between items-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">المحول (¥)</p>
                        <p class="text-xl font-headline font-bold text-primary" x-text="'¥ ' + formatNumber(record.rmb_amount)"></p>
                    </div>
                </div>
                <button @click="saveRecord(record)" class="w-full teal-gradient text-white py-4 rounded-xl font-bold text-sm shadow-xl shadow-primary/20 transition-all active:scale-95">حفظ التغييرات</button>
            </div>
        </template>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function dashboardApp() {
        return {
            records: @json($records),
            stats: @json($stats),
            csrfToken: '{{ csrf_token() }}',
            operationId: {{ $operation->id }},

            init() {
                console.log('Premium Ledger Initialized');
            },

            formatNumber(num) {
                return new Number(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            },

            updateRmb(record) {
                record.rmb_amount = (parseFloat(record.dollar_amount || 0) * parseFloat(record.exchange_rate || 0)).toFixed(2);
                this.calculateStats();
            },

            calculateStats() {
                this.stats.total_dollar = this.records.reduce((acc, r) => acc + parseFloat(r.dollar_amount || 0), 0);
                this.stats.total_rmb = this.records.reduce((acc, r) => acc + parseFloat(r.rmb_amount || 0), 0);
                this.stats.total_payments = this.records.reduce((acc, r) => acc + parseFloat(r.shop_payment || 0), 0);
                this.stats.remaining = (this.stats.total_rmb - this.stats.total_payments).toFixed(2);
            },

            async addRecord() {
                const response = await fetch(`/operations/${this.operationId}/records`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken }
                });
                if (response.ok) {
                    const data = await response.json();
                    this.records.unshift(data);
                    this.calculateStats();
                }
            },

            async saveRecord(record) {
                const response = await fetch(`/records/${record.id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken },
                    body: JSON.stringify(record)
                });
                if (response.ok) {
                    // Success feedback
                    console.log('Saved successfully');
                }
            }
        }
    }
</script>
@endpush
