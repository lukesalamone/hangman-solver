import java.util.ArrayList;
import java.util.List;
import java.io.IOException;
import java.nio.charset.Charset;
import java.nio.file.*;

public class Parse{
	public static void main(String[] args){
		ArrayList<String> dictionary = new ArrayList<>();

		try{
			for(String word: Files.readAllLines(Paths.get("dictionary.txt"))) {
				dictionary.add(word);
			}
		} catch(IOException e){
			e.printStackTrace();
		}


		System.out.println("read in " + dictionary.size() + " lines from file");

		for(int i=1; i<30 && (dictionary.size() != 0); i++){
			System.out.println("**********writing " + i + " letter words to file**********");
			dictionary = writeWords(dictionary, i);
		}

	}// end main method

	// write n-letter words to separate file, removing from master dictionary as we go
	private static ArrayList<String> writeWords(ArrayList<String> dictionary, int length){
		List<String> copy = dictionary;
		List<String> wordList = new ArrayList<>();

		// step backwards to avoid concurrent modification exception
		for(int i=0; i<copy.size(); i++){
			String word = copy.get(i);
			if(word.length() == length){
				wordList.add(word);
				dictionary.remove(word);
				System.out.println("added " + word + " to file");
			}
		}

		try{
			Path file = Paths.get(length + "_letters.txt");
			Files.write(file, wordList, Charset.forName("UTF-8"));
		} catch(IOException e){
			e.printStackTrace();
		}

		return dictionary;
	}
}// end Parse class