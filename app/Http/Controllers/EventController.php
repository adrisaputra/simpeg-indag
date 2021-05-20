<?php

namespace App\Http\Controllers;

use App\Models\Event;   //nama model
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
  
             return response()->json($data);
        }
  
        return view('admin.event.calendar');
    }

    ## Tampilkan Form Create
    public function create()
    {
        $title = 'Tambah Agenda';
		$view=view('admin.event.create', compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'start' => 'required',
			'end2' => 'required'
        ]);

		$input['title'] = $request->title;
		$input['start'] = $request->start;
		$input['end'] = date('Y-m-d', strtotime( $request->end2 . " +1 days"));
		$input['end2'] = $request->end2;

        Event::create($input);
		
		return redirect('/agenda')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit(Event $agenda)
    {
        $title = 'Ubah Agenda';
        $view=view('admin.event.edit', compact('title','agenda'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, Event $agenda)
    {
        $this->validate($request, [
            'title' => 'required',
            'start' => 'required',
			'end2' => 'required'
        ]);

		$agenda->fill($request->all());

		$agenda->end = date('Y-m-d', strtotime( $request->end2 . " +1 days"));
		$agenda->end2 = $request->end2;

    	$agenda->save();
		
		return redirect('/agenda')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Event $agenda)
    {
        $id = $agenda->id;
		$agenda->delete();
		
        return redirect('/agenda')->with('status', 'Data Berhasil Dihapus');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
              $event = Event::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end
              ]);
 
              return response()->json($event);
             break;
  
           case 'update':
              $event = Event::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Event::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }

}
