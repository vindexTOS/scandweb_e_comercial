import React from "react";

const Status = ({ message, type }: { message: string; type: string }) => {
  const baseStyles = "p-4 mb-4 text-sm rounded-lg absolute w-auto bottom-2  left-2";
  const errorStyles =
    "text-red-700 bg-red-100 dark:bg-red-200 dark:text-red-800";
  const successStyles =
    "text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800";

  return (
    <div
      className={
        type === "error"
          ? `${baseStyles} ${errorStyles}`
          : `${baseStyles} ${successStyles}`
      }
    >
      {message}
    </div>
  );
};

export default Status;
