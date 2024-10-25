<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function employees(){
        try {
            $employees = Employee::all();

            return response()->json(['status' => 'success', 'message' => 'Success get data employees', 'data' => $employees]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function index()
    {
        return view('admin.employees.index');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = Storage::move($request->file('file')->getRealPath(), 'temp/' . $request->file('file')->getClientOriginalName());
            // $path = $request->file('file')->store('photos', 'public');
            return response()->json(['filePath' => $path]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'entry_date' => 'required|date',
            'photo' => 'image|max:2048', // Validasi untuk setiap file foto
            'documents' => 'array|max:10',
        ]);



        // Simpan data pegawai ke database
        $employee = Employee::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'position' => $validated['position'],
            'entry_date' => $validated['entry_date'],
            'phone_number' => $validated['phone_number'],
        ]);

        if($validated['photo']){
            // Simpan foto yang diupload
            $photoPath = $validated['photo']->store('images', 'public');

            // Jika ingin menyimpan path foto ke database, bisa tambahkan di sini
            $employee->update(['photo' => $photoPath]); // Misalkan ada kolom photo_path di tabel employees
        }

        if($request['documents']){
            foreach ($validated['documents'] as $document) {
                $documentPath = $document->store('documents', 'public');

                // Jika ingin menyimpan path dokumen ke database, bisa tambahkan di sini
                $employee->documents()->create([
                    'path' => $documentPath,
                    'filename' => $document->getClientOriginalName()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Employee created successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('documents')->findOrFail($id);

        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
 * Remove the specified resource from storage.
 */
    public function destroy(string $id)
    {
        // Temukan data employee berdasarkan ID
        $employee = Employee::findOrFail($id);

        // Hapus file gambar yang diupload
        if ($employee->photo) {
            // Menghapus file gambar dari storage
            Storage::disk('public')->delete($employee->photo); // Menggunakan disk public
        }

        // Hapus semua detail employee yang terkait
        if($employee->documents()->count() > 0){
            foreach ($employee->documents as $document) {
                Storage::disk('public')->delete($document->path); // Menggunakan disk public
            }
        }

        // Hapus data employee
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }

}
