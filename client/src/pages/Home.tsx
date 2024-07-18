import React, { Component } from "react";
import { Product } from "../Types/ProductsInterface";
import { connect } from "react-redux";
import { fetchProducts } from "../Store/Products/Products.thunk";
import ProductCard from "../Components/ProductCard";
import { fetchCategories } from "../Store/Categories/Categories.thunk";
interface HomeProps {
  products: Product[];
  status: string;
  error: string | null;
  currentCategory: string;
  fetchProducts: (query: string) => void;
}

class Home extends Component<HomeProps> {
  componentDidMount() {
    this.props.fetchProducts(
      "{ products { name id gallery inStock  prices { id amount currency { label symbol } }} }"
    );
    console.log(this.props.currentCategory);
  }

  render() {
    const { products, status, error, currentCategory } = this.props;

    if (status === "loading") {
      return <div>Loading...</div>;
    }

    if (status === "failed") {
      return <div>Error: {error}</div>;
    }

    return (
      <div className={this.style.mainDiv}>
        <header className={this.style.header}>{currentCategory}</header>
        <section className={this.style.cardsSection}>
          {products.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </section>
      </div>
    );
  }
  private style = {
    mainDiv: "w-[100%] h-[100%] flex  flex-col py-10 ",
    header: "text-[3rem] text-gray-800 px-[8rem] pb-20",
    cardsSection:
      "flex flex-wrap gap-10   items-center justify-center  w-[100%]",
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
