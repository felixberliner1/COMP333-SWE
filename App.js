import * as React from "react";
import { Button, Text } from "react-native";
import { NavigationContainer } from "@react-navigation/native";
import { createStackNavigator } from "@react-navigation/stack";
import { useState} from "react";
import { TextInput } from "react-native-gesture-handler";
import {View} from "react-native";
import axios from "axios";
const Stack = createStackNavigator();

const MyStack = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator>
        <Stack.Screen
          name="Home"
          component={HomeScreen}
          options={{ title: "Ratings Table" }}
        />
        <Stack.Screen name="Profile" component={ProfileScreen} />
        <Stack.Screen name = "Create" component={CreateScreen} />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

const HomeScreen = ({ navigation }) => {

  return (
    <Button
      title="Add New Entry"
      onPress={() => navigation.navigate("Create")}
    />
  );
};

const CreateScreen = ({navigation}) => {
  const [song, setSong] = useState("");
  const [artist, setArtist] = useState("");
  const [rating, setRating] = useState("0");
  const [result, setResult] = useState("");

   const createSubmit = () => {
    if (song == "" || !song || song.length <= 0) {
      alert("Please enter a song name");
      return false;
    }
    if (artist == "" || !artist || artist.length <= 0) {
      alert("Please enter an artist name");
      return false;
    }

    axios.post('https://192.168.1.176/create.php', {
      "song" : song, 
      "artist" : artist, 
      "rating" : parseInt(rating)
    })
    .then((response) => {
      console.log(response);
      console.log((response.data));
      navigation.goBack();
      console.log("TEST1");
    })
    .catch((error) => {
      console.log(error);
      console.log((error.message));
      console.log("TEST2");
    }); 
    console.log("NOTHING");

    navigation.goBack();
   }

   const createChangeRating = (text) => {
      let newText = "";
      let numbers = "0123456789";
      for (var i = 0; i < text.length; i++) {
        if (numbers.indexOf(text[i]) > -1 ) {
          newText = newText + text[i];
        }
        else {
          alert("Please enter a number into ratings");
          return false;
        }
      }
      setRating(newText)
   }

   return (
    <View>
      <Text>Create New Rating</Text>
      <TextInput
      placeholder = "Song Name"
      onChangeText={text => setSong(text)}
      />
      <TextInput 
      placeholder = "Artist Name"
      onChangeText={text => setArtist(text)}
      />
      <TextInput 
      keyboardType = "numeric"
      placeholder = "0"
      onChangeText={(text) => createChangeRating(text)}
      maxLength = {1}
      />
      <Button 
      title = "Submit"
      onPress={createSubmit}
      />
    </View>
   )
} 

const ProfileScreen = ({ navigation, route }) => {
  return <Text>This is {route.params.name}'s profile</Text>;
};

export default MyStack;