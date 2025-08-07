<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            有給詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex">
                        <a href="{{ route('public.reports.paid-requests.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mr-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                        @can('approval', $paidRequest)
                            @if (empty($paidRequest->approver))
                                <form action="{{ route('public.reports.paid-requests.approval', $paidRequest->id) }}" method="POST" onsubmit="return confirm('有給申請を許可しますか？');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">承認</button>
                                </form>
                            @endif
                                @endcan                                        
                        @can('acceptance', $paidRequest)
                            @if (isset($paidRequest->approver) && empty($paidRequest->recipient))
                                <form action="{{ route('public.reports.paid-requests.acceptance', $paidRequest->id) }}" method="POST" onsubmit="return confirm('有給申請を受理しますか？');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">受理</button>
                                </form>
                            @endif
                        @endcan
                    </div>
                    <p class="mb-2">申請日 : {{ $paidRequest->application_date }}</p>
                    <p class="mb-2">社員番号 : {{ $paidRequest->employee_id }}</p>
                    <p class="mb-2">所属 : {{ $paidRequest->affiliation }}</p>
                    <p class="mb-2">社員名 : {{ $paidRequest->employee_name }}</p>
                    <p class="mb-2">開始日 : {{ $paidRequest->start_date }}</p>
                    <p class="mb-2">終了日 : {{ $paidRequest->end_date }}</p>
                    <p class="mb-2">日数 : {{ $paidRequest->days }}</p>
                    <p class="mb-2">区分 : {{ $paidRequest->distinction }}</p>
                    <p class="mb-2">理由 : {{ $paidRequest->reason }}</p>
                    <p class="mb-2">備考 : {{ $paidRequest->note }}</p>
                    <p class="mb-2">承認者 : {{ $paidRequest->approver }}</p>
                    <p class="mb-2">受理者 : {{ $paidRequest->recipient }}</p>
                </div>


            </div>
        </div>
    </div>
</x-app-layout>

