<?php

namespace App\Http\Controllers;

use App\Models\ReturnedItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnedItemsController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnedItem::query();

        // DATE FROM
        if ($request->filled('date_from')) {
            $query->whereRaw(
                "STR_TO_DATE(CONCAT(year,'-',month,'-',day), '%Y-%m-%d') >= ?",
                [$request->date_from]
            );
        }

        // DATE TO
        if ($request->filled('date_to')) {
            $query->whereRaw(
                "STR_TO_DATE(CONCAT(year,'-',month,'-',day), '%Y-%m-%d') <= ?",
                [$request->date_to]
            );
        }

        // CREATED BY
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // Add relationship for creator
        $query->with('creator:id,name');
        
        // Conditional pagination - automatically disable when filtering by date
        $disablePagination = false;
        if ($request->filled('date_from') || $request->filled('date_to')) {
            // Automatically disable pagination when date filters are applied
            $disablePagination = true;
        }
        
        // Manual override with checkbox
        if ($request->filled('disable_pagination') && $request->disable_pagination == '1') {
            $disablePagination = true;
        }
        
        if ($disablePagination) {
            $items = $query->latest()->get();
            $paginated = false;
        } else {
            $items = $query->latest()->paginate(15)->withQueryString();
            $paginated = true;
        }

        $creatorIds = ReturnedItem::distinct()->pluck('created_by');

        // Get the users with only id and name
        $creators = User::whereIn('id', $creatorIds)
            ->select('id', 'name')
            ->get();

        return view('pages.returned-items.index', compact('items', 'creators', 'paginated'));
    }

    public function create()
    {
        return view('pages.returned-items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day'   => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year'  => 'required|integer',
            
            // Inbound
            'warehouse' => 'nullable|integer|min:0',
            'inbound_transit' => 'nullable|integer|min:0',
            'inbound_returned' => 'nullable|integer|min:0',
            'ordinary_mail_transit' => 'nullable|integer|min:0',
            'ordinary_mail_returned' => 'nullable|integer|min:0',

            // UV
            'uv_dispatches' => 'nullable|integer|min:0',
            'uv_items' => 'nullable|integer|min:0',
            'uv_weight' => 'nullable|numeric|min:0',

            // UA
            'ua_dispatches' => 'nullable|integer|min:0',
            'ua_items' => 'nullable|integer|min:0',
            'ua_weight' => 'nullable|numeric|min:0',

            // UL
            'ul_dispatches' => 'nullable|integer|min:0',
            'ul_items' => 'nullable|integer|min:0',
            'ul_weight' => 'nullable|numeric|min:0',
        ]);

        $data['created_by'] = Auth::id();

        ReturnedItem::create($data);

        return redirect()
            ->route('returned-items.index')
            ->with('success', 'Returned item created successfully');
    }

    public function edit($id)
    {
        $item = ReturnedItem::findOrFail($id);
        return view('pages.returned-items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = ReturnedItem::findOrFail($id);

        $data = $request->validate([
            'day'   => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year'  => 'required|integer',
            '*'     => 'nullable|numeric|min:0'
        ]);

        $item->update($data);

        return redirect()
            ->route('pages.returned-items.index')
            ->with('success', 'Returned item updated successfully');
    }

    public function destroy($id)
    {
        ReturnedItem::findOrFail($id)->delete();

        return back()->with('success', 'Returned item deleted');
    }

    public function approve($id)
    {
        $item = ReturnedItem::findOrFail($id);
        $item->approved_at = now();
        $item->save();

        return back()->with('success', 'Returned item approved');
    }
}
