import React, { ReactNode } from 'react';
import { useParams } from 'react-router-dom';

const withRouter = (Component:any) => {
  return (props:any) => {
    const params = useParams();
    return <Component {...props} params={params} />;
  };
};

export default withRouter;