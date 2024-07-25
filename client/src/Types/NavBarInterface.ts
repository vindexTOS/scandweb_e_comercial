import { Category } from "./CategoriesInterface";
import { CartProduct } from "./ProductsInterface";

export interface NavBarInterface {
  navItems: Category[];
  cartItems: CartProduct[];
}
