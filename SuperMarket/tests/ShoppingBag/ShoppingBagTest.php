<?php

namespace CodingKatas\SuperMarket\Tests;

use CodingKatas\SuperMarket\Product;
use CodingKatas\SuperMarket\ShoppingBag\ShoppingBag;
use CodingKatas\SuperMarket\ShoppingBag\ShoppingBagItem;

class ShoppingBagTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_be_initializable()
    {
        $shoppingBag = new ShoppingBag();

        $this->assertInstanceOf(ShoppingBag::class, $shoppingBag);
    }

    public function test_it_should_be_initializable_when_passing_an_array_of_shopping_bag_items()
    {
        /** @var ShoppingBagItem[] $data */
        $data = [
            'id' => new ShoppingBagItem(
                $this->getMockBuilder(Product::class)->disableOriginalConstructor()->getMock(),
                1
            ),
        ];
        $shoppingBag = new ShoppingBag($data);

        $this->assertSame([$data["id"]->product()], $shoppingBag->productsInShoppingBag());
    }

    public function test_is_product_in_shopping_bag_should_return_true()
    {
        $product = $this->getMockBuilder(Product::class)->disableOriginalConstructor()->getMock();
        $product->expects($this->any())
            ->method("identity")
            ->willReturn("id");
        $data = [
            'id' => new ShoppingBagItem(
                $product,
                1
            ),
        ];

        $shoppingBag = new ShoppingBag($data);

        $this->assertTrue($shoppingBag->isProductInShoppingBag($product));
    }

    public function test_is_product_in_shopping_bag_should_return_false()
    {
        $product = $this->getMockBuilder(Product::class)->disableOriginalConstructor()->getMock();
        $product->expects($this->once())
            ->method("identity")
            ->willReturn("id");

        $shoppingBag = new ShoppingBag();

        $this->assertFalse($shoppingBag->isProductInShoppingBag($product));
    }

    public function test_it_should_put_products_into_shopping_bag()
    {
        $product = $this->getMockBuilder(Product::class)->disableOriginalConstructor()->getMock();
        $product->expects($this->any())
            ->method("identity")
            ->willReturn("id");

        $shoppingBag = new ShoppingBag();
        $shoppingBag->putProductIntoShoppingBag($product);

        $this->assertSame([$product], $shoppingBag->productsInShoppingBag());
        $this->assertTrue($shoppingBag->isProductInShoppingBag($product));
        $this->assertSame(1, $shoppingBag->howOftenIsProductInShoppingBag($product));
    }

    public function test_it_should_remove_products_from_shopping_bag()
    {
        $product = $this->getMockBuilder(Product::class)->disableOriginalConstructor()->getMock();
        $product->expects($this->any())
            ->method("identity")
            ->willReturn("id");
        $data = [
            'id' => new ShoppingBagItem(
                $product,
                1
            ),
        ];

        $shoppingBag = new ShoppingBag($data);
        $shoppingBag->removeProductFromShoppingBag($product);

        $this->assertSame([], $shoppingBag->productsInShoppingBag());
        $this->assertFalse($shoppingBag->isProductInShoppingBag($product));
        $this->assertSame(0, $shoppingBag->howOftenIsProductInShoppingBag($product));
    }
}