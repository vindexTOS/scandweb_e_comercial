import React, { Component } from "react";
import { Product } from "../Types/ProductsInterface";
import { connect } from "react-redux";
import { fetchProducts } from "../Store/Products/Products.thunk";
import ProductCard from "../Components/Product/ProductCard";
import { fetchCategories } from "../Store/Categories/Categories.thunk";
import { Category } from "../Types/CategoriesInterface";
import ProductCardLoadingSkeleton from "../Components/Skeletons/ProductCardLoadingSkeleton";
interface HomeProps {
  products: Product[];
  status: string;
  error: string | null;
  currentCategory: Category;
  fetchProducts: (query: string) => void;
}

class Home extends Component<HomeProps> {
  componentDidMount() {
    this.fetchProductsForCategory(this.props.currentCategory.id);
  }
  componentDidUpdate(prevProps: HomeProps) {
    if (this.props.currentCategory.id !== prevProps.currentCategory.id) {
      this.fetchProductsForCategory(this.props.currentCategory.id);
    }
  }

  fetchProductsForCategory(categoryId: string) {
    const categoryQuery = `{ products(category: "${categoryId}") { name id gallery inStock category  attributes { id name type items { id displayValue value } }  prices { id amount currency { label symbol } }} }`;
    this.props.fetchProducts(categoryQuery);
  }
  render() {
    const { products, status, error, currentCategory } = this.props;

    if (status === "failed") {
      return <div>Error: {error}</div>;
    }

    return (
      <div className={this.style.mainDiv}>
        <header className={this.style.header}>{currentCategory.name}</header>

        <section className={this.style.cardsSection}>
          {status === "loading" ? (
            <>
              {new Array(8).fill("").map((item: string, index: number) => (
                <ProductCardLoadingSkeleton key={index} />
              ))}
            </>
          ) : (
            <>
              {products.map((product) => (
                <ProductCard key={product.id} product={product} />
              ))}
            </>
          )}
        </section>
      </div>
    );
  }
  private style = {
    mainDiv: "w-[100%] h-[100%] flex  flex-col py-20  ",
    header: "text-[3rem] text-gray-800 px-[8rem] pb-20",
    cardSectionWrapper: "w-[100%] flex items-center justify-center",
    cardsSection:
      "flex flex-wrap  gap-10   items-center justify-center  w-[100%]",
  };
}

const mapStateToProps = (state: any) => ({
  products: state.products.items,
  status: state.products.status,
  error: state.products.error,
  currentCategory: state.categories.currentCategory,
});

const mapDispatchToProps = {
  fetchProducts,
  fetchCategories,
};

export default connect(mapStateToProps, mapDispatchToProps)(Home);
