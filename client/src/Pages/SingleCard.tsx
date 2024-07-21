import React, { Component } from 'react';
import withRouter from '../Routing/withRouter';
 
interface SingleCardProps {
  params: {
    id: string;
  };
}

class SingleCard extends Component<SingleCardProps> {
  render() {
    const { id } = this.props.params; // Access the id parameter from the props
    return <div>SingleCard with ID: {id}</div>;
  }
}

export default withRouter(SingleCard);