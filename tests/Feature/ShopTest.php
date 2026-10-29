<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    #[TestDox('Unauthorized user try to get shops, but get redirect to login page')]
    public function test_unauthorized_user_redirect_to_login(): void
    {
        $response = $this->get('/shops');
        $response->assertRedirect(route('login'));
    }

    #[TestDox('Create shop with empty name and get error')]
    public function test_create_shop_with_empty_name_and_get_error(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shops.store'),['name' => '',]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('shops', 0);
    }

    #[TestDox('User create shop and see this shop in page')]
    public function test_user_create_shop_and_see_this_shop_in_page(): void
    {
        $user = User::factory()->create();
        Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home'
        ]);

        $response = $this->actingAs($user)->get('/shops');
        $response->assertStatus(200);
        $response->assertSee('Maxi near my home');
    }

    #[TestDox('User create shop by post and check shop in DB')]
    public function test_user_create_shop_by_post_and_check_them_in_db(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shops.store'),
            [
                'name' => 'Maxi',
                'display_name' => 'Maxi near my home',
                'address' => 'Gagarinova street 5',
            ]);

        $this->assertDatabaseHas('shops', [
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
            'address' => 'Gagarinova street 5',
        ]);

        $response->assertRedirect(route('shops.index'));
    }

    #[TestDox('User create shop, edit them and see them in page')]
    public function test_user_create_shop_edit_them_and_see_them_in_page(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
            'address' => 'Gagarinova street 5',
        ]);

        $response = $this->actingAs($user)->get('/shops');
        $response->assertStatus(200);
        $response->assertSee('Maxi near my home');

        $shop->update([
            'name' => 'Lidl',
            'display_name' => 'Lidl near my home',
        ]);

        $response = $this->actingAs($user)->get('/shops');
        $response->assertStatus(200);
        $response->assertSee('Lidl near my home');
    }

    #[TestDox('User create shop, edit them by put and check them in DB')]
    public function test_user_create_shop_edit_them_by_put_and_check_them_id_db(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
            'address' => 'Gagarinova street 5',
        ]);

        $response = $this->actingAs($user)->get('/shops');
        $response->assertStatus(200);
        $response->assertSee('Maxi near my home');

        $response = $this->actingAs($user)->put(route('shops.update', $shop->id),
            [
                'name' => 'Lidl',
                'display_name' => 'Lidl near my home',
                'address' => 'Novi Sadska street 30',
            ]);

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'user_id' => $user->id,
            'name' => 'Lidl',
            'display_name' => 'Lidl near my home',
            'address' => 'Novi Sadska street 30',
        ]);

        $response->assertRedirect(route('shops.show', $shop->id));
    }

    #[TestDox('User create shop and remove them')]
    public function test_user_create_shop_and_remove_them(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
        ]);

        $response = $this->actingAs($user)->get('/shops');
        $response->assertStatus(200);
        $response->assertSee('Maxi near my home');

        $response = $this->actingAs($user)->delete(route('shops.destroy', $shop->id));
        $response->assertRedirect(route('shops.index'));

        $this->assertDatabaseMissing('shops', [
            'id' => $shop->id,
        ]);

        $this->app['session']->forget('success');

        $response = $this->actingAs($user)->get('/shops');

        $response->assertViewHas('shops', function ($shops) use ($shop) {
            return ! $shops->contains('id', $shop->id);
        });

        $response->assertStatus(200);
        $response->assertDontSee('Maxi near my home');
    }

    #[TestDox('Attacker dont see alien shop')]
    public function test_attacker_dont_see_alien_shop(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)->get(route('shops.show', $shop->id));
        $response->assertStatus(403);
        $response->assertDontSee('Maxi near my home');
    }


    #[TestDox('Attacker dont see edit page of alien shop')]
    public function test_attacker_dont_see_edit_page_of_alien_shop(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)->get(route('shops.edit', $shop->id));
        $response->assertStatus(403);
        $response->assertDontSee('Maxi near my home');
    }

    #[TestDox('Attacker dont see confirm delete page of alien shop')]
    public function test_attacker_dont_see_confirm_delete_page_of_alien_shop(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)->get(route('shops.delete', $shop->id));
        $response->assertStatus(403);
        $response->assertDontSee('Maxi near my home');
    }

    #[TestDox('Attacker dont edit alien shop')]
    public function test_attacker_dont_edit_alien_shop(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
            'address' => 'Gagarinova street 5',
        ]);

        $body = [
            'name' => 'Hacked!',
            'display_name' => 'Hacked',
            'address' => 'Hacked',
        ];

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)
            ->put(route('shops.update', $shop->id), $body);

        $response->assertStatus(403);

        $this->actingAs($userAttacker)->get(route('shops.index'))->assertDontSee('Hacked!');
        $this->actingAs($userAttacker)->get(route('shops.index'))->assertDontSee('Maxi near my home');

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
            'address' => 'Gagarinova street 5',
        ]);
        $this->actingAs($user)->get(route('shops.index'))->assertSee('Maxi near my home');
    }


    #[TestDox('Attacker don\'t delete alien shop')]
    public function test_attacker_dont_delete_alien_shop(): void
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
        ]);

        $userAttacker = User::factory()->create();
        $response = $this->actingAs($userAttacker)
            ->delete(route('shops.destroy', $shop->id));

        $response->assertStatus(403);

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'user_id' => $user->id,
            'name' => 'Maxi',
            'display_name' => 'Maxi near my home',
        ]);
        $this->actingAs($user)->get(route('shops.index'))->assertSee('Maxi near my home');
    }
}
