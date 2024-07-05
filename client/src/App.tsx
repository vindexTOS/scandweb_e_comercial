import React, { Component } from "react";
import "./App.css";
import Robika from "./components/Robika";

interface AppState {
  message: string;
}

class App extends Component<{}, AppState> {
  constructor(props: {}) {
    super(props);
    this.state = {
      message: "Hello, world!",
    };
  }

  render() {
    return (
      <div className="App">
        <Robika />
        <header className="App-header">
          <p>{this.state.message}</p>
        </header>
      </div>
    );
  }
}

export default App;
