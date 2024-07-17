import React, { Component } from "react";
import { Product } from "../Types/ProductsInterface";
import { connect } from "react-redux";
import { fetchProducts } from "../Store/Products/Products.thunk";

interface HomeProps {
  products: Product[];
  status: string;
  error: string | null;
  fetchProducts: (query: string) => void;
}

class Home extends Component<HomeProps> {
  componentDidMount() {
    this.props.fetchProducts("{ products { name id } }");
  }

  render() {
    const { products, status, error } = this.props;

    if (status === "loading") {
      return <div>Loading...</div>;
    }

    if (status === "failed") {
      return <div>Error: {error}</div>;
    }

    return (
      <div>
        Home
        <ul>
          {products.map((product: Product) => (
            <li key={product.id}>{product.name}</li>
          ))}
        </ul>
      </div>
    );
  }
}

const mapStateToProps = (state: any) => ({
  products: state.products.items,
  status: state.products.status,
  error: state.products.error,
});

const mapDispatchToProps = { fetchProducts };

export default connect(mapStateToProps, mapDispatchToProps)(Home);
