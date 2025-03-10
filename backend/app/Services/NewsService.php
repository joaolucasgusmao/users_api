<?php

namespace App\Services;

use App\Exceptions\AppError;
use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsService
{

    public function store(array $data, Request $request): News
    {
        $user = $request->user();

        $categories = $data['categories'];
        unset($data['categories']);

        $news = $user->news()->create($data);

        $news->categories()->sync($categories);

        return $news;
    }

    public function get(): Collection
    {
        return News::oldest("id")->get();
    }

    public function retrieve(int $id): News
    {
        $news = News::find($id);

        if (!$news) {
            throw new AppError("News not found.", 404);
        }

        return $news;
    }

    public function update(int $id, array $data): News
    {
        $news = News::find($id);

        if (!$news) {
            throw new AppError("News not found.", 404);
        }

        if (array_key_exists("categories", $data)) {
            $categories = $data["categories"] ?? [];
            unset($data["categories"]);
            $news->categories()->sync($categories);
        }

        $news->update($data);
        return $news;
    }

    public function destroy(int $id): void
    {
        $news = News::find($id);

        if (!$news) {
            throw new AppError("News not found.", 404);
        }

        $news->delete();
    }

    public function getNewsByCategory(int $id): Collection
    {
        $news = News::whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->get();

        if ($news->isEmpty()) {
            throw new AppError("News not found.", 404);
        }

        return $news;
    }

    public function getNewsByUser(Request $request, int $userId): Collection
    {
        $user = $request->user();

        if ($user->is_admin) {
            $news = News::where('user_id', $userId)->get();

            if ($news->isEmpty()) {
                throw new AppError("News not found.", 404);
            }

            return $news;
        }

        if ($user->id !== $userId) {
            throw new AppError("Unauthorized", 401);
        }

        if ($user->news->isEmpty()) {
            throw new AppError("News not found.", 404);
        }

        return $user->news;
    }

    public function getNewsPaginate(): LengthAwarePaginator
    {
        return News::paginate(10);
    }
}
