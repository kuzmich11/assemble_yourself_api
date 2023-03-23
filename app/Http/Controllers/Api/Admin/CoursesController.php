<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Courses\CreateRequest;
use App\Http\Requests\Admin\Courses\EditRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return \view('admin.courses.index', ['courses' => Course::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return \view('admin.courses.create', ['authors' => User::where('is_author', 'TRUE')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $course = Course::create($request->validated());

        if ($course) {
            return \redirect()->route('admin.courses.index')
                ->with('status', 'Курс успешно добавлен!');
        }
        return \back()->with('error', 'Не удалось добавить курс!');
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @return View
     */
    public function edit(Course $course): View
    {
        return \view('admin.courses.edit', ['course' => $course, 'authors' => User::where('is_author', 'TRUE')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function update(EditRequest $request, Course $course): RedirectResponse
    {
        $course = $course->fill($request->validated());
        if ($course->save()) {
            return \redirect()->route('admin.courses.index')
                ->with('status', 'Курс успешно обновлен!');
        }
        return \back()->with('error', 'Не удалось обновить курс!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course): JsonResponse
    {
        try{
            $course->delete();
            return \response()->json('ok');
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage(), [$exception]);
            return \response()->json('error', 400);
        }
    }
}
