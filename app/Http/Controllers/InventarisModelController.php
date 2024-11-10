<?php

namespace App\Http\Controllers;

use App\Models\InventarisModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InventarisModelController extends Controller
{
    /**
     * Display a listing of the inventory items.
     *
     * @return \Illuminate\View\View
     */
    public function menu()
    {
        $inventaris = InventarisModel::all();
        return view('manageInventaris.v_reportAlatMedis', compact('inventaris'));
    }

    /**
     * Retrieve all inventory items as JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInventoryItems()
    {
        $inventaris = InventarisModel::all();
        return response()->json(['success' => true, 'data' => $inventaris]);
    }

    /**
     * Store a new inventory item or update an existing one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        // Check if this is an update or a new item
        $item = $request->id ? InventarisModel::find($request->id) : new InventarisModel();
    
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }
    
        // Assign form data to the model
        $item->name = $request->name;
        $item->description = $request->description;
        $item->jumlah_masuk = $request->jumlah_masuk;
        $item->jumlah_keluar = $request->jumlah_keluar;
        $item->total = $request->jumlah_masuk - $request->jumlah_keluar;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($item->image_path && $request->id) {
                Storage::disk('public')->delete($item->image_path);
            }
    
            // Store the new image in the 'public/inventaris' folder
            $path = $request->file('image')->storeAs('inventaris', $request->file('image')->getClientOriginalName(), 'public');
            $item->image_path = $path; // Save the relative path in the database
        }
    
        $item->save();
    
        return response()->json(['success' => true, 'message' => $request->id ? 'Item updated successfully' : 'Item added successfully']);
    }
    

    /**
     * Retrieve a specific inventory item by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInventoryItem($id)
    {
        $item = InventarisModel::findOrFail($id);
        return response()->json(['success' => true, 'item' => $item]);
    }

    /**
     * Remove the specified inventory item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = InventarisModel::findOrFail($id);

        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return response()->json(['success' => true, 'message' => 'Item berhasil dihapus dari inventaris.']);
    }
    public function updateInventoryItem(Request $request, $id)
{
    // Find the item by ID
    $item = InventarisModel::find($id);

    // Check if the item exists
    if (!$item) {
        return response()->json(['success' => false, 'message' => 'Item not found']);
    }

    // Update fields
    $item->name = $request->name;
    $item->description = $request->description;
    $item->jumlah_masuk = $request->jumlah_masuk;
    $item->jumlah_keluar = $request->jumlah_keluar;
    $item->total = $request->jumlah_masuk - $request->jumlah_keluar;

    // Handle image upload if a new image is provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        // Store the new image and update the image path
        $path = $request->file('image')->storeAs('inventaris', $request->file('image')->getClientOriginalName(), 'public');
        $item->image_path = $path;
    }

    // Save the updated item to the database
    $item->save();

    return response()->json(['success' => true, 'message' => 'Item updated successfully']);
}

    
}
