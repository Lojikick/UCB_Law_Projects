import React, { useState } from "react";
import Avatar from "@material-ui/core/Avatar";
import Button from "@material-ui/core/Button";
import CssBaseline from "@material-ui/core/CssBaseline";
import TextField from "@material-ui/core/TextField";
import Typography from "@material-ui/core/Typography";
import { makeStyles } from "@material-ui/core/styles";
import Container from "@material-ui/core/Container";
import Box from "@material-ui/core/Box";
import Copyright from "./Copyright";
import logo from "./ucbseal.png";
import axios from "axios";

function Login({ setLoggedIn }) {
  //initial state of the Login component.
  //Empty username/password, empty error message/success message
  const initialState = {
    userInfo: {
      username: "",
      password: "",
    },
    errorMsg: "",
    successMsg: "",
  };

  //state is the state variable, the UseState hook manages the state
  //upon calling setState(data), the state will be updaate with the new data
  const [state, setState] = useState(initialState);
  // On change input value (username & password)

  //event handler function which updates the initial state based on the inputs linked to the userInfo field being updated
  //If User types into the "Username" input field, likewise username in the state wilol be updated
  const onChangeValue = (e) => {
    setState({
      ...state,
      userInfo: {
        ...state.userInfo,
        [e.target.name]: e.target.value,
      },
    });
  };

  

  // Upon submit login form, the below event handler function determines how the state updates based on the results from the call to the api 
  //handled by login.php
  
  const submitForm = async (event) => {
    event.preventDefault();

    //Sends the user info (username, password) to login.php
    const res = await axios.post("http://localhost/Fall2021/react-intro/backend/login.php", state.userInfo);
    //
    console.log(state.userInfo.username);
    localStorage.setItem("loginToken", res.data.token);
    localStorage.setItem("Username", state.userInfo.username);
    localStorage.setItem("Password", state.userInfo.password);
    localStorage.setItem("meal", res.data.meal);

    //If the Username and Password was correct, the child Login component updates the login state of the parent APP component through the setLoggedInProp
    //Returns the current state to the initial state
    if (res.data.success && res.data.token) {
      setLoggedIn(true);
      setState({
        ...initialState,
      });
    //If inccorrect, the Userinfo of the state is kept the same, but the state's errorMessage is updated and shown
    } else {
      setState({
        ...state,
        successMsg: "",
        errorMsg: res.data.message,
      });
      console.log(state);
    }
  };

  // Show Message on Error or Success
  let successMsg = "";
  let errorMsg = "";
  if (state.errorMsg) {
    errorMsg = <div className="error-msg">{state.errorMsg}</div>;
  }
  if (state.successMsg) {
    successMsg = <div className="success-msg">{state.successMsg}</div>;
  }


  //JSX returned by the Login component:
  const useStyles = makeStyles((theme) => ({
    paper: {
      marginTop: theme.spacing(8),
      display: "flex",
      flexDirection: "column",
      alignItems: "center",
    },
    avatar: {
      margin: theme.spacing(1),
      backgroundColor: theme.palette.secondary.main,
    },
    form: {
      width: "100%", // Fix IE 11 issue.
      marginTop: theme.spacing(1),
    },
    submit: {
      margin: theme.spacing(3, 0, 2),
      backgroundColor: "#31A2E1",
      color: "white",
    },
    calnet: {
      margin: theme.spacing(1, 0, 3),
      backgroundColor: "#69B45D",
      color: "white",
    },
  }));

  const classes = useStyles();

  return (
    <Container component="main" maxWidth="xs">
      <CssBaseline />
      <div className={classes.paper}>
        <Avatar src={logo} className={classes.avatar}></Avatar>
        <Typography component="h1" variant="h5">
          Sign in
        </Typography>
        <form onSubmit={submitForm} className={classes.form} noValidate>
          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth
            id="username"
            label="Username"
            name="username"
            autoComplete="username"
            autoFocus
            value={state.userInfo.username}
            onChange={onChangeValue}
          />
          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth
            name="password"
            label="Password"
            type="password"
            id="password"
            autoComplete="current-password"
            value={state.userInfo.password}
            onChange={onChangeValue}
          />
          <div>
            {errorMsg}
            {successMsg}
          </div>
          <Button
            type="submit"
            fullWidth
            variant="contained"
            className={classes.submit}
          >
            Sign In
          </Button>
          <Button
            type="submit"
            fullWidth
            variant="contained"
            className={classes.calnet}
          >
            Sign in with CalNet Id
          </Button>
        </form>
      </div>
      <Box mt={8}>
        <Copyright />
      </Box>
    </Container>
  );
}

export default Login;
