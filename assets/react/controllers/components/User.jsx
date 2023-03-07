import React, { useEffect, useState } from "react";
import { getUsers } from "../Api/Users";

const User = () => {

    const [users, setUsers] = useState([]);
    
    // useEffect(() => {
    //     getUsers()
    //         .then((json) => setUsers(json))
    // }, []);

    useEffect(() => {
        fetchDatos();
    },[]);
    
    const fetchDatos = async () => {

    
        try {
            const respuesta = await fetch(
              getUsers()
            );
            const data = await respuesta.json();
            
            setUsers(data);
            console.log(users);


          } catch (error) {
            console.log("Error: " + error);
          }

    };

    
    return (
        <div>
            {users.map((user) => (
                <div key={user.id}>
                    <p>{user.name}</p>
                    <p>{user.email}</p>
                </div>
            ))}
            {/* <p>{users}</p> */}
        </div>
    );
};



export default User;