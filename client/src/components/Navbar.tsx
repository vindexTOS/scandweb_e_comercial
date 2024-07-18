import React, { Component } from "react";
import { connect } from "react-redux";
import Logo from "../Assets/a-logo.png";
import Cart from "../Assets/Empty Cart.png";
import { NavBarInterface } from "../Types/NavBarInterface";
import { fetchCategories } from "../Store/Categories/Categories.thunk";

interface NavbarProps {
  navItems: NavBarInterface["navItems"];
  loading: boolean;
  error: string | null;
  fetchCategories: () => void;
}

class Navbar extends Component<NavbarProps> {
  state: NavBarInterface = {
    navItems: [],
    selectedNavItem: "all",
  };

  componentDidMount() {
    this.props.fetchCategories();
  }

  componentDidUpdate(prevProps: NavbarProps) {
    if (prevProps.navItems !== this.props.navItems) {
      this.setState({ navItems: this.props.navItems });
    }
  }

  handleNavItemSelect = (itemName: string) => {
    this.setState({ selectedNavItem: itemName });
  };

  render() {
    const { loading, error } = this.props;

    if (loading) {
      return <div>Loading...</div>;
    }

    if (error) {
      return <div>Error: {error}</div>;
    }

    return (
      <nav className={this.styles.nav}>
        <section className={this.styles.navLinks}>
          {this.state.navItems?.map((item) => (
            <div
              key={item.id}
              className={`cursor-pointer ${
                this.state.selectedNavItem === item.name
                  ? "text-green-500 border-b-2 border-green-500"
                  : ""
              }`}
              onClick={() => this.handleNavItemSelect(item.name)}
            >
              {item.name.toUpperCase()}
            </div>
          ))}
        </section>
        <div>
          <img src={Logo} alt="Logo" />
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
});

const mapDispatchToProps = {
  fetchCategories,
};

export default connect(mapStateToProps, mapDispatchToProps)(Navbar);
