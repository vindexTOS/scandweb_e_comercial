import React, { Component } from "react";
import { connect } from "react-redux";
import Logo from "../Assets/a-logo.png";
import Cart from "../Assets/Empty Cart.png";
import { NavBarInterface } from "../Types/NavBarInterface";
import { fetchCategories } from "../Store/Categories/Categories.thunk";
import { getCategory } from "../Store/Categories/Categories.slice";
import { Category } from "../Types/CategoriesInterface";
import { StatusType } from "../Types/StatusInterface";
import { Link } from "react-router-dom";

interface NavbarProps {
  navItems: NavBarInterface["navItems"];
  status: StatusType;
  error: string | null;
  fetchCategories: () => void;
  getCategory: (category: Category) => void;
  currentCategory: Category;
}

class Navbar extends Component<NavbarProps> {
  state: NavBarInterface = {
    navItems: [],
  };

  componentDidMount() {
    this.props.fetchCategories();
  }

  componentDidUpdate(prevProps: NavbarProps) {
    if (prevProps.navItems !== this.props.navItems) {
      this.setState({ navItems: this.props.navItems });
    }
  }

  handleNavItemSelect = (item: Category) => {
    this.props.getCategory(item);
  };

  render() {
    const { status, error } = this.props;

    if (status == "loading") {
      return <div>Loading...</div>;
    }

    if (error) {
      return <div>Error: {error}</div>;
    }

    return (
      <nav className={this.styles.nav}>
        <section className={this.styles.navLinks}>
          {this.state.navItems?.map((item) => (
            <Link
              to="/"
              key={item.id}
              className={`cursor-pointer ${
                this.props.currentCategory.name === item.name
                  ? "text-green-500 border-b-2 border-green-500"
                  : ""
              }`}
              onClick={() => this.handleNavItemSelect(item)}
            >
              {item.name.toUpperCase()}
            </Link>
          ))}
        </section>
        <div>
          <Link to="/">
            <img src={Logo} alt="Logo" />
          </Link>
        </div>
        <div>
          <img src={Cart} alt="Cart" />
        </div>
      </nav>
    );
  }

  private styles = {
    nav: "h-[80px] w-[100%] flex items-center  justify-between px-[8rem] ",
    navLinks: "flex justify-between  gap-10 ",
  };
}

const mapStateToProps = (state: any) => ({
  navItems: state.categories.navItems,
  loading: state.categories.loading,
  error: state.categories.error,
  currentCategory: state.categories.currentCategory,
});

const mapDispatchToProps = {
  fetchCategories,
  getCategory,
};

export default connect(mapStateToProps, mapDispatchToProps)(Navbar);
