@extends('layouts.app')

@section('title', 'قائمة العمليات - Aeon Finance')

@section('header_title')
<div class="flex items-center gap-4">
    <h1 class="text-2xl md:text-[3.5rem] font-headline font-bold text-on-surface leading-tight tracking-tight">قائمة العمليات</h1>
</div>
@endsection

@section('content')
<div x-data="operationsApp()" x-init="init()" class="max-w-7xl mx-auto space-y-8 text-right relative">
    
    <!-- New Operation Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-300">
        <div @click.away="showModal = false" class="bg-white w-full max-w-md rounded-[2rem] p-8 shadow-2xl border border-slate-100 text-right">
            <h2 class="text-2xl font-headline font-bold text-teal-900 mb-6">إنشاء عملية جديدة</h2>
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-teal-800 mb-2 mr-1 uppercase tracking-widest">اسم العملية</label>
                    <input type="text" x-model="newData.name" class="w-full bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-primary/20 rounded-2xl py-4 px-4 text-right font-medium" placeholder="مثلاً: توريد بضاعة شنجن">
                </div>
                <div>
                    <label class="block text-xs font-bold text-teal-800 mb-2 mr-1 uppercase tracking-widest">تاريخ العملية</label>
                    <input type="date" x-model="newData.operation_date" class="w-full bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-primary/20 rounded-2xl py-4 px-4 text-right font-medium">
                </div>
                <div class="flex gap-4 pt-4">
                    <button @click="submitOperation()" class="flex-1 teal-gradient text-white py-4 rounded-xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-2">
                        <span x-show="submitting" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        <span x-show="!submitting">حفظ العملية</span>
                        <span x-show="!submitting" class="material-symbols-outlined text-lg">save</span>
                    </button>
                    <button @click="showModal = false" class="flex-1 bg-slate-100 text-slate-600 py-4 rounded-xl font-bold hover:bg-slate-200 transition-all">إلغاء</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters Tray -->
    <div class="flex flex-wrap gap-2 items-center text-sm mb-6">
        <span class="text-on-surface-variant font-medium ml-2">نشط:</span>
        <div class="bg-white border border-surface-container-highest rounded-full px-3 py-1 flex items-center gap-1 text-on-surface shadow-sm">
            <span>الكل</span>
            <span class="material-symbols-outlined text-xs cursor-pointer hover:text-error transition-colors">close</span>
        </div>
        <button class="text-primary text-xs font-medium hover:underline mr-2">مسح الكل</button>
    </div>

    <!-- Header Actions (Desktop) -->
    <div class="hidden md:flex justify-end items-center mb-8">
        <button @click="showModal = true" class="teal-gradient text-on-primary font-medium py-3 px-8 rounded-xl flex items-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
            <span class="material-symbols-outlined">add</span>
            عملية جديدة
        </button>
    </div>

    <!-- Mobile Actions Bar -->
    <div class="md:hidden flex flex-col gap-4 mb-8">
        <button @click="showModal = true" class="w-full teal-gradient text-on-primary font-medium py-3 px-6 rounded-xl flex items-center justify-center gap-2 shadow-sm">
            <span class="material-symbols-outlined">add</span>
            عملية جديدة
        </button>
    </div>

    <!-- Bento Grid - Operations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="operation in sortedOperations" :key="operation.id">
            <a :href="'/operations/' + operation.id" 
               class="bg-white rounded-[1.25rem] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 flex flex-col group relative overflow-hidden border border-surface-container-highest/50">
                
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-10 group-hover:scale-110 transition-transform duration-500"></div>
                
                <div class="flex justify-between items-start mb-6">
                    <div class="px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1"
                         :class="{
                             'bg-primary/10 text-primary': operation.status === 'pending',
                             'bg-surface-container-high text-on-surface': operation.status === 'completed',
                             'bg-error-container text-on-error-container': operation.status === 'delayed'
                         }">
                        <span class="w-1.5 h-1.5 rounded-full"
                              :class="{
                                  'bg-primary animate-pulse': operation.status === 'pending',
                                  'bg-on-surface': operation.status === 'completed',
                                  'bg-error': operation.status === 'delayed'
                              }"></span>
                        <span x-text="operation.status === 'completed' ? 'مكتمل' : (operation.status === 'delayed' ? 'متأخر' : 'قيد التنفيذ')"></span>
                    </div>
                    <span class="text-on-surface-variant text-xs font-medium" x-text="formatDate(operation.operation_date)"></span>
                </div>
                
                <h3 class="text-xl font-headline font-bold text-on-surface mb-2 group-hover:text-primary transition-colors" x-text="operation.name"></h3>
                
                <p class="text-sm text-on-surface-variant mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">receipt_long</span>
                    <span x-text="operation.records_count || 0"></span> معامله فرعية
                </p>
                
                <div class="mt-auto space-y-3 pt-4 border-t border-surface-container-high/50 border-dashed">
                    <div class="flex justify-between items-end">
                        <span class="text-xs text-on-surface-variant">القيمة الإجمالية</span>
                        <div class="text-right">
                            <p class="text-lg font-bold font-headline text-on-surface tracking-tight" x-text="'$' + formatNumber(operation.total_dollar)"></p>
                            <p class="text-xs text-on-surface-variant" x-text="'¥' + formatNumber(operation.total_rmb)"></p>
                        </div>
                    </div>
                </div>
            </a>
        </template>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function operationsApp() {
        return {
            operations: @json($operations),
            showModal: false,
            submitting: false,
            newData: {
                name: '',
                operation_date: new Date().toISOString().split('T')[0]
            },
            csrfToken: '{{ csrf_token() }}',

            init() {
                console.log('Accounting Grid Active');
            },

            get sortedOperations() {
                return this.operations.sort((a, b) => b.id - a.id);
            },

            formatDate(dateStr) {
                if (!dateStr) return '';
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Date(dateStr).toLocaleDateString('ar-EG', options);
            },

            formatNumber(num) {
                return new Number(num || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            },

            async submitOperation() {
                if (!this.newData.name) {
                    alert('يرجى إدخال اسم العملية');
                    return;
                }
                this.submitting = true;
                try {
                    const response = await fetch('{{ route('operations.store_main') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrfToken },
                        body: JSON.stringify(this.newData)
                    });
                    if (response.ok) {
                        const data = await response.json();
                        this.operations.unshift(data);
                        this.showModal = false;
                        this.newData.name = '';
                    } else {
                        alert('حدث خطأ أثناء الحفظ');
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.submitting = false;
                }
            }
        }
    }
</script>
@endpush
