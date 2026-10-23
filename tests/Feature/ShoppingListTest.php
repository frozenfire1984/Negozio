<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use App\Models\User;
use App\Models\ShoppingList;

class ShoppingListTest extends TestCase
{
    use RefreshDatabase;

    #[TestDox('Unauthorized user try to get shopping lists, but get redirect to login page')]
    public function test_unauthorized_user_redirect_to_login(): void
    {
        $response = $this->get('/shopping-lists');
        $response->assertRedirect(route('login'));
    }


    #[TestDox('Create list with empty name and get error')]
    public function test_create_list_with_empty_name_and_get_error(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shopping-lists.store'),['name' => '',]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('shopping_lists', 0);
    }

    #[TestDox('User create list and see this list in page')]
    public function test_user_create_list_and_see_this_list_in_page(): void
    {
        $user = User::factory()->create();
        ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $response = $this->actingAs($user)->get('/shopping-lists');
        $response->assertStatus(200);
        $response->assertSee('Shopping list for Lidl shop');
    }

    #[TestDox('User create list by post and check them in DB')]
    public function test_user_create_list_by_post_and_check_them_in_db(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shopping-lists.store'),
            [
                'name' => 'Shopping list for Lidl shop',
                'notes' => 'Don\'t forget take discount card'
            ]);

        $this->assertDatabaseHas('shopping_lists', [
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
            'notes' => 'Don\'t forget take discount card'
        ]);

        $response->assertRedirect(route('shopping-lists.index'));
    }

    #[TestDox('User create list, edit them and see them in page')]
    public function test_user_create_list_edit_them_and_see_them_in_page(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $response = $this->actingAs($user)->get('/shopping-lists');
        $response->assertStatus(200);
        $response->assertSee('Shopping list for Lidl shop');

        $list->update([
            'name' => 'Shopping list for Maxi shop',
        ]);

        $response = $this->actingAs($user)->get('/shopping-lists');
        $response->assertStatus(200);
        $response->assertSee('Shopping list for Maxi shop');
    }

    #[TestDox('User create list, edit them by put and check them in DB')]
    public function test_user_create_list_edit_them_by_put_and_check_them_id_db(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $response = $this->actingAs($user)->get('/shopping-lists');
        $response->assertStatus(200);
        $response->assertSee('Shopping list for Lidl shop');

        $response = $this->actingAs($user)->put(route('shopping-lists.update', $list->id),
            [
                'name' => 'Shopping list for Maxi shop',
                'notes' => 'Don\'t forget take package bag'
            ]);

        $this->assertDatabaseHas('shopping_lists', [
            'id' => $list->id,
            'user_id' => $user->id,
            'name' => 'Shopping list for Maxi shop',
            'notes' => 'Don\'t forget take package bag'
        ]);

        $response->assertRedirect(route('shopping-lists.index'));
    }

    #[TestDox('User create list and remove them')]
    public function test_user_create_list_and_remove_them(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $response = $this->actingAs($user)->get('/shopping-lists');
        $response->assertStatus(200);
        $response->assertSee('Shopping list for Lidl shop');

        $response = $this->actingAs($user)->delete(route('shopping-lists.destroy', $list->id));
        $response->assertRedirect(route('shopping-lists.index'));

        $this->assertDatabaseMissing('shopping_lists', [
            'id' => $list->id,
        ]);

        $response = $this->actingAs($user)->get('/shopping-lists');
        $response->assertStatus(200);
        $response->assertDontSee('Shopping list for Lidl shop');
    }

    #[TestDox('Attacker dont see alien shopping list')]
    public function test_attacker_dont_see_alien_shopping_list(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)->get(route('shopping-lists.show', $list->id));
        $response->assertStatus(403);
        $response->assertDontSee('Shopping list for Lidl shop');
    }


    #[TestDox('Attacker dont see edit page of alien shopping list')]
    public function test_attacker_dont_see_edit_page_of_alien_shopping_list(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)->get(route('shopping-lists.edit', $list->id));
        $response->assertStatus(403);
        $response->assertDontSee('Shopping list for Lidl shop');
    }

    #[TestDox('Attacker dont see confirm delete page of alien shopping list')]
    public function test_attacker_dont_see_confirm_delete_page_of_alien_shopping_list(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)->get(route('shopping-lists.delete', $list->id));
        $response->assertStatus(403);
        $response->assertDontSee('Shopping list for Lidl shop');
    }

    #[TestDox('Attacker dont steal alien shopping list')]
    public function test_attacker_dont_steal_alien_shopping_list(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
            'notes' => 'Don\'t forget take discount card'
        ]);

        $body = [
            'name' => 'Hacked!',
            'notes' => 'Hacked',
        ];

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)
            ->put(route('shopping-lists.update', $list->id), $body);

        $response->assertStatus(403);

        $this->actingAs($userAttacker)->get(route('shopping-lists.index'))->assertDontSee('Hacked!');
        $this->actingAs($userAttacker)->get(route('shopping-lists.index'))->assertDontSee('Shopping list for Lidl shop');

        $this->assertDatabaseHas('shopping_lists', [
            'id' => $list->id,
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
            'notes' => 'Don\'t forget take discount card'
        ]);
        $this->actingAs($user)->get(route('shopping-lists.index'))->assertSee('Shopping list for Lidl shop');
    }


    #[TestDox('Attacker dont delete alien shopping list')]
    public function test_attacker_dont_delete_alien_shopping_list(): void
    {
        $user = User::factory()->create();
        $list = ShoppingList::factory()->create([
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
            'notes' => 'Don\'t forget take discount card'
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)
            ->delete(route('shopping-lists.destroy', $list->id));

        $response->assertStatus(403);

        $this->assertDatabaseHas('shopping_lists', [
            'id' => $list->id,
            'user_id' => $user->id,
            'name' => 'Shopping list for Lidl shop',
            'notes' => 'Don\'t forget take discount card'
        ]);
        $this->actingAs($user)->get(route('shopping-lists.index'))->assertSee('Shopping list for Lidl shop');
    }
}
