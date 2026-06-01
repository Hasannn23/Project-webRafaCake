@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ 
    showCreateModal: false, 
    showEditModal: false, 
    editId: null, editName: '', editEmail: '' 
}">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800"> Kelola User</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola semua member yang terdaftar</p>
        </div>
        <button @click="showCreateModal = true" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg shadow-sm transition flex items-center gap-2 text-sm cursor-pointer">
             Tambah User
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($users->isEmpty())
            <div class="text-center py-12">
                
                <p class="text-gray-500 mt-3">Belum ada member terdaftar.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-4 font-semibold">#</th>
                            <th class="p-4 font-semibold">Nama</th>
                            <th class="p-4 font-semibold">Email</th>
                            <th class="p-4 font-semibold">Tanggal Daftar</th>
                            <th class="p-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($users as $i => $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-800 text-sm">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <button @click="showEditModal = true; editId = {{ $user->id }}; editName = '{{ addslashes($user->name) }}'; editEmail = '{{ addslashes($user->email) }}'" 
                                        class="text-xs bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                         Edit
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 px-3 rounded-lg transition cursor-pointer">
                                             Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ============================================ --}}
    {{-- CREATE USER MODAL --}}
    {{-- ============================================ --}}
    <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showCreateModal = false"></div>
            <div x-show="showCreateModal" x-transition class="relative bg-white rounded-xl shadow-xl max-w-md w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"> Tambah User Baru</h3>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="email@contoh.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" required minlength="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Minimal 6 karakter">
                        </div>
                        <div class="flex justify-end gap-3 pt-3 border-t">
                            <button type="button" @click="showCreateModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition cursor-pointer"> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- EDIT USER MODAL --}}
    {{-- ============================================ --}}
    <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showEditModal = false"></div>
            <div x-show="showEditModal" x-transition class="relative bg-white rounded-xl shadow-xl max-w-md w-full z-10">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"> Edit User</h3>
                    <form :action="'/admin/users/' + editId" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" x-model="editName" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" x-model="editEmail" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 text-xs">(kosongkan jika tidak ingin diubah)</span></label>
                            <input type="password" name="password" minlength="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Minimal 6 karakter">
                        </div>
                        <div class="flex justify-end gap-3 pt-3 border-t">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition cursor-pointer"> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
