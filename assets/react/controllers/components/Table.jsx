import React, { useEffect, useState } from "react";
// import { getTables } from "../Api/Tables";

const Table = () => {
    const [tables, setTables] = useState();
    useEffect(() => {
        fetchDatos();
    });
    const fetchDatos = async () => {
        try {
            const respuesta = fetch("http://127.0.0.1:8000/admin/tables");
            const json = await respuesta.json();
            // console.log("buenas tardes");
            console.log(json);
            setTables(json);
        }
        catch (error) {
            console.log("error: " + error);
        }
    };
    return (
        <div>
            {/* {tables.map((ta)=>
                {ta}
            )} */}
            {/* <p>{users}</p> */}
        </div>
    );
};
export default Table;